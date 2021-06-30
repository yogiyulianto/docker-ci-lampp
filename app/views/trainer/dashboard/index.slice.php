@extends('base.default.app')
@section('title')
Dashboard
@endsection
@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Dashboard</h2>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="flaticon-coins"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total Pendapatan</p>
                                <h4 class="card-title">{{rupiah($total_income ?? '0')}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-info bubble-shadow-small">
                                <i class="flaticon-archive"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total Pelatihan</p>
                                <h4 class="card-title">{{$total_courses ?? '0'}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="flaticon-users"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total Siswa</p>
                                <h4 class="card-title">{{$total_students ?? '0'}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="row">
        <div class="col-md-6">
            <div class="card full-height">
                <div class="card-header">
                    <div class="card-head">
                        <div class="card-title">Pembelian Pelatihan Saya</div>
                    </div>
                </div>
                <div class="card-body">
                    @forelse ($rs_transactions as $item)
                    <div class="d-flex">
                        <div class="flex-1 ml-3 pt-1">
                            <h6 class="text-uppercase fw-bold mb-1">{{$item['student_name']}}
                            </h6>
                            <span class="text-muted">{{$item['course_name']}}</span>
                        </div>
                        <div class="float-right pt-1">
                            <small class="text-muted">{{$this->tdtm->nicetime($item['mdd'])}}</small>
                        </div>
                    </div>
                    <div class="separator-dashed"></div>
                    @empty 
                    <div class="d-flex">
                        <div class="flex-1 ml-3 pt-1">
                            <h6 class="text-uppercase fw-bold mb-1">Belum Ada Pembelian</h6>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div> -->
</div>
@endsection
