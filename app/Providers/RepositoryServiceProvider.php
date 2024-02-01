<?php

namespace App\Providers;

use App\Repository\AssignRepository;
use App\Repository\AttachmentRepository;
use App\Repository\DepartmentRepository;
use App\Repository\BaseRepository;
use App\Repository\DistrictRepository;
use App\Repository\DocumentRepository;
use App\Repository\FileRepository;
use App\Repository\FileTypeRepository;
use App\Repository\FiscalYearRepository;
use App\Repository\Interfaces\AssignRepositoryInterface;
use App\Repository\Interfaces\AttachmentRepositoryInterface;
use App\Repository\Interfaces\DepartmentRepositoryInterface;
use App\Repository\Interfaces\DistrictRepositoryInterface;
use App\Repository\Interfaces\DocumentRepositoryInterface;
use App\Repository\Interfaces\EloquentRepositoryInterface;
use App\Repository\Interfaces\FileRepositoryInterface;
use App\Repository\Interfaces\FileTypeRepositoryInterface;
use App\Repository\Interfaces\FiscalYearRepositoryInterface;
use App\Repository\Interfaces\InvoiceRepositoryInterface;
use App\Repository\Interfaces\MunicipalityRepositoryInterface;
use App\Repository\Interfaces\PrivilegeRepositoryInterface;
use App\Repository\Interfaces\ProvinceRepositoryInterface;
use App\Repository\Interfaces\ReceiverRepositoryInterface;
use App\Repository\Interfaces\RegistrationRepositoryInterface;
use App\Repository\Interfaces\RevisionRepositoryInterface;
use App\Repository\Interfaces\RoleRepositoryInterface;
use App\Repository\Interfaces\ServiceRepositoryInterface;
use App\Repository\Interfaces\UserRepositoryInterface;
use App\Repository\InvoiceRepository;
use App\Repository\MunicipalityRepository;
use App\Repository\PrivilegeRepository;
use App\Repository\ProvinceRepository;
use App\Repository\ReceiverRepository;
use App\Repository\RegistrationRepository;
use App\Repository\RevisionRepository;
use App\Repository\RoleRepository;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(FiscalYearRepositoryInterface::class, FiscalYearRepository::class);
        $this->app->bind(MunicipalityRepositoryInterface::class, MunicipalityRepository::class);
        $this->app->bind(DistrictRepositoryInterface::class, DistrictRepository::class);
        $this->app->bind(ProvinceRepositoryInterface::class, ProvinceRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RegistrationRepositoryInterface::class, RegistrationRepository::class);
        $this->app->bind(PrivilegeRepositoryInterface::class, PrivilegeRepository::class);
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
        $this->app->bind(FileTypeRepositoryInterface::class, FileTypeRepository::class);
        $this->app->bind(ServiceRepositoryInterface::class, ServiceRepository::class);
        $this->app->bind(DocumentRepositoryInterface::class, DocumentRepository::class);
        $this->app->bind(FileRepositoryInterface::class, FileRepository::class);
        $this->app->bind(RevisionRepositoryInterface::class, RevisionRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
