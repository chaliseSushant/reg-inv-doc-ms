<?php

namespace App\Http\Controllers;

use App\Facade\LogActivityFacade;
use App\Http\Requests\InvoiceStoreRequest;
use App\Http\Resources\DocumentInvoiceResource;
use App\Http\Resources\InvoicesResource;
use App\Http\Resources\ViewInvoiceResource;
use App\Models\Invoice;
use App\Repository\Interfaces\DocumentRepositoryInterface;
use App\Repository\Interfaces\FiscalYearRepositoryInterface;
use App\Repository\Interfaces\InvoiceRepositoryInterface;
use App\Traits\SuccessMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;

class InvoiceController extends Controller
{
    use SuccessMessage;

    private $invoiceRepository;
    private $fiscalYearRepository;
    private $documentRepository;

    public function __construct(InvoiceRepositoryInterface $invoiceRepository,
                                FiscalYearRepositoryInterface $fiscalYearRepository,
    DocumentRepositoryInterface $documentRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->fiscalYearRepository = $fiscalYearRepository;
        $this->documentRepository = $documentRepository;
    }
    public function index()
    {
        $invoices = $this->invoiceRepository->getAllInvoices(10);
        return InvoicesResource::collection($invoices);
    }

    public function viewInvoice($invoice_id)
    {
        $invoice = $this->invoiceRepository->getInvoice($invoice_id);
        return new ViewInvoiceResource($invoice);
    }

    public function viewDocument($invoice_id)
    {
        $document_id = $this->invoiceRepository->findById($invoice_id)->documents->first()->pivot->document_id;

        $user_id = Auth::guard('api')->id();
        $latestAssign = $this->documentRepository->getLatestAssigns($document_id);
        $assignPermission = $this->documentRepository->getAssignPermission($latestAssign, $user_id);

        if(!$assignPermission)
        {
            return response()->json($this->getErrorMessage('Not authorised for this action '),JsonResponse::HTTP_UNAUTHORIZED);
        } else {
            $invoice = $this->documentRepository->getFileDocument($document_id);
            return new DocumentInvoiceResource($invoice);
        }
    }

    public function store(InvoiceStoreRequest $request)
    {
        $user_id = Auth::guard('api')->id();
        $latestAssign = $this->documentRepository->getLatestAssigns($request->document_id);
        $assignPermission = $this->documentRepository->getAssignPermission($latestAssign, $user_id);

        if(!$assignPermission)
        {
            return response()->json($this->getErrorMessage('Not authorised for this action '),201);
        } else {

            $sender = Auth::guard('api')->user()->name . ', '. Auth::guard('api')->user()->department->name;

            try {

                DB::beginTransaction();

                $fiscal_year_id = $this->fiscalYearRepository->getFiscalYearActive();

                $fillable_array_invoice = [
                    "invoice_number" => $request->invoice_number,
                    "invoice_datetime" => Carbon::now(),
                    "sender" => $sender,
                    "attender_book_number" => $request->attender_book_number,
                    "subject" => $request->subject,
                    "receiver" => $request->receiver,
                    "medium" => 1, //Manual = 1, Interconnect = 1 , Email = 1
                    "remarks" => $request->invoice_remarks,
                    "fiscal_year_id" => $fiscal_year_id,
                ];

                /*$dataInvoice = $this->invoiceRepository->create( $fillable_array_invoice );
                $this->invoiceRepository->createInvoiceDocumentable($request->document_id, $dataInvoice->id);*/
                $dataInvoice = $this->invoiceRepository->createInvoice($fillable_array_invoice,$request->document_id);

                LogActivityFacade::addToLog('Created Invoice Manual '.'"'.$dataInvoice->id.'"');
                DB::commit();

                $response = ["success" => "Invoice created successfully."];
                return response()->json($response,201);

            }catch(\Exception $exp){
                DB::rollBack();
                Log::error($exp->getMessage());
                return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
            }
        }
    }


}
