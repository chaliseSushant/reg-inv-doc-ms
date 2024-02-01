<?php

namespace App\Repository;

use App\Exceptions\ErrorPageException;
use App\Models\Invoice;
use App\Repository\Interfaces\DocumentRepositoryInterface;
use App\Repository\Interfaces\InvoiceRepositoryInterface;

class InvoiceRepository extends BaseRepository implements InvoiceRepositoryInterface
{
    private $documentRepository;

    public function __construct(Invoice $model,
                                DocumentRepositoryInterface $documentRepository)
    {
        parent::__construct($model);
        $this->documentRepository = $documentRepository;
    }

    public function getAllInvoices($paginate)
    {
        try {
            return $this->model
                //->with('service')
                ->with(['documents'=> function($q){$q->select('id','attribute');}])
                ->orderBy('created_at', 'DESC')->paginate($paginate);
        } catch(\Exception $ex){
            throw new ErrorPageException();
        }
    }

    public function getInvoice($invoice_id)
    {
        if($this->model->where('id', $invoice_id)->exists()) {
            return $this->model
                ->where('id',$invoice_id)
                ->first();
        } else {
            throw new ErrorPageException();
        }
    }

    public function createInvoiceDocumentable($document_id, $invoice_id)
    {
        return $this->findById($invoice_id)->documents()->attach($this->documentRepository->findById($document_id));
    }

    public function createInvoice(array $fillable,$document_id)
    {
        $dataInvoice = $this->create( $fillable );
        $this->createInvoiceDocumentable($document_id, $dataInvoice->id);
        return $dataInvoice;
    }

}
