@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل
                    الفاتورة</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">

        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <!-- div -->
            <div class="card" id="tabs-style4">
                <div class="card-body">
                    <div class="text-wrap">
                        <div class="example">
                            <div class="d-md-flex">
                                <div class="">
                                    <div class="panel panel-primary tabs-style-4">
                                        <div class="tab-menu-heading">
                                            <div class="tabs-menu ">
                                                <!-- Tabs -->
                                                <ul class="nav panel-tabs ml-3">
                                                    <li class=""><a href="#tab21" class="nav-link active"
                                                            data-toggle="tab">معلومات الفاتورة </a></li>
                                                    <li><a href="#tab22" class="nav-link " data-toggle="tab">حالات
                                                            الدفع</a></li>
                                                    <li><a href="#tab23" class="nav-link " data-toggle="tab">المرفقات</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tabs-style-4 ">
                                    <div class="panel-body tabs-menu-body main-content-body-right border">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab21">
                                                <div class="table-responsive mt-15">
                                                    <table class="table table-striped" style="text-align:center">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">رقم الفاتورة</th>
                                                                <td>{{ $invoices->invoice_number }}</td>
                                                                <th scope="row">تاريخ الاصدار</th>
                                                                <td>{{ $invoices->invoice_date }}</td>
                                                                <th scope="row">تاريخ الاستحقاق</th>
                                                                <td>{{ $invoices->due_date }}</td>
                                                                <th scope="row">القسم</th>
                                                                <td>{{ $invoices->section->section_name }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">المنتج</th>
                                                                <td>{{ $invoices->product }}</td>
                                                                <th scope="row">مبلغ التحصيل</th>
                                                                <td>{{ $invoices->amount_collection }}</td>
                                                                <th scope="row">مبلغ العمولة</th>
                                                                <td>{{ $invoices->amount_commission }}</td>
                                                                <th scope="row">الخصم</th>
                                                                <td>{{ $invoices->discount }}</td>
                                                            </tr>


                                                            <tr>
                                                                <th scope="row">نسبة الضريبة</th>
                                                                <td>{{ $invoices->rate_vat }}</td>
                                                                <th scope="row">قيمة الضريبة</th>
                                                                <td>{{ $invoices->value_vat }}</td>
                                                                <th scope="row">الاجمالي مع الضريبة</th>
                                                                <td>{{ $invoices->total }}</td>
                                                                <th scope="row">الحالة الحالية</th>

                                                                @if ($invoices->value_status == 1)
                                                                    <td><span
                                                                            class="badge badge-pill badge-success">{{ $invoices->status }}</span>
                                                                    </td>
                                                                @elseif($invoices->value_status == 2)
                                                                    <td><span
                                                                            class="badge badge-pill badge-danger">{{ $invoices->status }}</span>
                                                                    </td>
                                                                @else
                                                                    <td><span
                                                                            class="badge badge-pill badge-warning">{{ $invoices->status }}</span>
                                                                    </td>
                                                                @endif
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">ملاحظات</th>
                                                                <td>{{ $invoices->note }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>


                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab22">
                                                <div class="table-responsive mt-15">
                                                    <table class="table center-aligned-table mb-0 table-hover"
                                                        style="text-align:center">
                                                        <thead>
                                                            <tr class="text-dark">
                                                                <th>#</th>
                                                                <th>رقم الفاتورة</th>
                                                                <th>نوع المنتج</th>
                                                                <th>القسم</th>
                                                                <th>حالة الدفع</th>
                                                                <th>تاريخ الدفع </th>
                                                                <th>ملاحظات</th>
                                                                <th>تاريخ الاضافة </th>
                                                                <th>المستخدم</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 0; ?>
                                                            @foreach ($details as $detail)
                                                                <?php $i++; ?>
                                                                <tr>
                                                                    <td>{{ $i }}</td>
                                                                    <td>{{ $detail->invoice_number }}</td>
                                                                    <td>{{ $detail->product }}</td>
                                                                    <td>{{ $invoices->section->section_name }}</td>
                                                                    @if ($detail->status_value == 1)
                                                                        <td><span
                                                                                class="badge badge-pill badge-success">{{ $detail->status }}</span>
                                                                        </td>
                                                                    @elseif($detail->status_value == 2)
                                                                        <td><span
                                                                                class="badge badge-pill badge-danger">{{ $detail->status }}</span>
                                                                        </td>
                                                                    @else
                                                                        <td><span
                                                                                class="badge badge-pill badge-warning">{{ $detail->status }}</span>
                                                                        </td>
                                                                    @endif
                                                                    <td>{{ $detail->payment_date }}</td>
                                                                    <td>{{ $detail->note }}</td>
                                                                    <td>{{ $detail->created_at }}</td>
                                                                    <td>{{ $detail->user }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>


                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab23">
                                                <!--المرفقات-->
                                                <div class="card card-statistics">
                                                    {{-- @can('اضافة مرفق') --}}
                                                    <div class="card-body">
                                                        <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                        <h5 class="card-title">اضافة مرفقات</h5>
                                                        <form method="post" action="{{ url('/InvoiceAttachments') }}"
                                                            enctype="multipart/form-data">
                                                            {{ csrf_field() }}
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input"
                                                                    id="customFile" name="file_name" required>
                                                                <input type="hidden" id="customFile" name="invoice_number"
                                                                    value="{{ $invoices->invoice_number }}">
                                                                <input type="hidden" id="invoice_id" name="invoice_id"
                                                                    value="{{ $invoices->id }}">
                                                                <label class="custom-file-label" for="customFile">حدد
                                                                    المرفق</label>
                                                            </div><br><br>
                                                            <button type="submit" class="btn btn-primary btn-sm "
                                                                name="uploadedFile">تاكيد</button>
                                                        </form>
                                                    </div>
                                                    {{-- @endcan --}}
                                                    <br>

                                                    <div class="table-responsive mt-15">
                                                        <table class="table center-aligned-table mb-0 table table-hover"
                                                            style="text-align:center">
                                                            <thead>
                                                                <tr class="text-dark">
                                                                    <th scope="col">م</th>
                                                                    <th scope="col">اسم الملف</th>
                                                                    <th scope="col">قام بالاضافة</th>
                                                                    <th scope="col">تاريخ الاضافة</th>
                                                                    <th scope="col">العمليات</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $i = 0; ?>
                                                                @foreach ($attachments as $attachment)
                                                                    <?php $i++; ?>
                                                                    <tr>
                                                                        <td>{{ $i }}</td>
                                                                        <td>{{ $attachment->file_name }}</td>
                                                                        <td>{{ $attachment->created_by }}</td>
                                                                        <td>{{ $attachment->created_at }}</td>
                                                                        <td colspan="2">


                                                                            <a class="btn btn-outline-success btn-sm"
                                                                                href="{{ asset('Attachments/' . $attachment->file_name) }}"
                                                                                role="button"><i
                                                                                    class="fas fa-eye"></i>&nbsp;
                                                                                عرض</a>



                                                                            <a class="btn btn-outline-info btn-sm"
                                                                                href="{{ url('download') }}/{{ $attachment->file_name }}"
                                                                                role="button"><i
                                                                                    class="fas fa-download"></i>&nbsp;
                                                                                تحميل</a>

                                                                            @can('حذف المرفق')
                                                                                <button class="btn btn-outline-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-file_name="{{ $attachment->file_name }}"
                                                                                    data-invoice_number="{{ $attachment->invoice_number }}"
                                                                                    data-id_file="{{ $attachment->id }}"
                                                                                    data-target="#delete_file">حذف</button>
                                                                            @endcan

                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </div>

                                            </div>
                                            {{-- ////// --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /div -->
            </div>
        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
@endsection
