@extends('layouts.blank')

@section('title', 'Print Berica Acara Approval BoQ Aktual')

@section('contents')
<div class="custom w-100">
    <table class="table w-100 watermark">
        <tbody>
            <tr class="p-0">
                <td colspan="5" class="text-center fs-1 p-0">BERITA ACARA APPROVAL BoQ AKTUAL</td>
            </tr>
            <tr>
                <td colspan="5" class="fs-7">Dokumen ini sebagai pengganti approval manual, berlaku hanya untuk nomor BoQ dengan nominal sesuai final negosiasi procurement</td>
            </tr>
            <tr class="p-0">
                <td colspan="5" class="fs-6 fw-bolder p-0">PID: {{$data['document']->pid}} Site Name: {{$data['document']->site_name}}</td>
            </tr>
            <tr class="p-0">
                <td colspan="5" class="fs-6 fw-bolder p-0">Nomor BoQ: {{$data['document']->nomor_boq}}</td>
            </tr>
            <tr class="p-0">
                <td colspan="5" class="fs-6 fw-bolder p-0">Nilai Final (Procurement): @php echo number_format($data['document']->amount_proc, 0, ',', '.');@endphp</td>
            </tr>
            <tr>
                <td colspan="5" class="fs-4">LogBook Approval</td>
            </tr>
            <tr class="border border-gray-800">
                <td class="fs-7 fw-bolder p-2 text-center fw-bolder">Urutan Approval</td>
                <td class="fs-7 p-2 text-center fw-bolder">PIC Approval</td>
                <td class="fs-7 p-2 text-center fw-bolder">Status Approval</td>
                <td class="fs-7 p-2 text-center fw-bolder">Approval Date</td>
                <td class="fs-7 p-2 text-center fw-bolder">Komentar</td>
                <td class="fs-7 p-2 text-center fw-bolder">Tambahan Approval</td>
            </tr>
            <tr class="border border-gray-800">
                <td style="font-size: 10px;" class="fw-bolder p-2">PM Status</td>
                <td style="font-size: 10px;" class="p-2">{{$data['document']->pm_name1}}<br>{{$data['document']->pm_nik}}<br>{{$data['document']->pm_posisi1}}</td>
                <td style="font-size: 10px;" class="p-2">
                    @if ($data['document']->pm_date != NULL)
                    APPROVED
                    @else
                    NY APPROVED
                    @endif
                </td>
                <td style="font-size: 10px;" class="p-2">
                    @if ($data['document']->pm_date != NULL)
                    {{$data['document']->pm_date}}
                    @else
                    NY Approved
                    @endif
                </td>
                <td style="font-size: 10px;" class="p-2">"{{$data['document']->pm_komentar}}"</td>
                <td style="font-size: 10px;" class="p-2">Nilai Awal: @php echo number_format($data['document']->amount_awal, 0, ',', '.');@endphp <br>
                    SoW: {{$data['document']->sow}}
                </td>
            </tr>
            <tr class="border border-gray-800">
                <td style="font-size: 10px;" class="fw-bolder p-2">MGR Regional Status</td>
                <td style="font-size: 10px;" class="p-2">{{$data['document']->mgr_region_name1}}<br>{{$data['document']->mgr_region_nik}}<br>{{$data['document']->mgr_region_posisi1}}</td>
                <td style="font-size: 10px;" class="p-2">
                    @if ($data['document']->mgr_region_date != NULL)
                    APPROVED
                    @else
                    NY APPROVED
                    @endif
                </td>
                <td style="font-size: 10px;" class="p-2">
                    @if ($data['document']->mgr_region_date != NULL)
                    {{$data['document']->mgr_region_date}}
                    @else
                    NY Approved
                    @endif
                </td>
                <td style="font-size: 10px;" class="p-2">"{{$data['document']->mgr_region_komentar}}"</td>
                <td style="font-size: 10px;" class="p-2"></td>
            </tr>
            <tr class="border border-gray-800">
                <td style="font-size: 10px;" class="fw-bolder p-2">GM Area Status</td>
                <td style="font-size: 10px;" class="p-2">{{$data['document']->gm_area_name1}}<br>{{$data['document']->gm_area_nik}}<br>{{$data['document']->gm_area_posisi1}}</td>
                <td style="font-size: 10px;" class="p-2">
                    @if ($data['document']->gm_area_date != NULL)
                    APPROVED
                    @else
                    NY APPROVED
                    @endif
                </td>
                <td style="font-size: 10px;" class="p-2">
                    @if ($data['document']->gm_area_date != NULL)
                    {{$data['document']->gm_area_date}}
                    @else
                    NY Approved
                    @endif
                </td>
                <td style="font-size: 10px;" class="p-2">"{{$data['document']->gm_area_komentar}}"</td>
                <td style="font-size: 10px;" class="p-2"></td>
            </tr>
            <tr class="border border-gray-800">
                <td style="font-size: 10px;" class="fw-bolder p-2">MGR Construction Status</td>
                <td style="font-size: 10px;" class="p-2">{{$data['document']->mgr_cons_name1}}<br>{{$data['document']->mgr_cons_nik}}<br>{{$data['document']->mgr_cons_posisi1}}</td>
                <td style="font-size: 10px;" class="p-2">
                    @if ($data['document']->mgr_cons_date != NULL)
                    APPROVED
                    @else
                    NY APPROVED
                    @endif
                </td>
                <td style="font-size: 10px;" class="p-2">
                    @if ($data['document']->mgr_cons_date != NULL)
                    {{$data['document']->mgr_cons_date}}
                    @else
                    NY Approved
                    @endif
                </td>
                <td style="font-size: 10px;" class="p-2">"{{$data['document']->mgr_cons_komentar}}"</td>
                <td style="font-size: 10px;" class="p-2"></td>
            </tr>
            <tr class="border border-gray-800">
                <td style="font-size: 10px;" class="fw-bolder p-2">GM Construction Status</td>
                <td style="font-size: 10px;" class="p-2">{{$data['document']->gm_cons_name1}}<br>{{$data['document']->gm_cons_nik}}<br>{{$data['document']->gm_cons_posisi1}}</td>
                <td style="font-size: 10px;" class="p-2">
                    @if ($data['document']->gm_cons_date != NULL)
                    APPROVED
                    @else
                    NY APPROVED
                    @endif
                </td>
                <td style="font-size: 10px;" class="p-2">
                    @if ($data['document']->gm_cons_date != NULL)
                    {{$data['document']->gm_cons_date}}
                    @else
                    NY Approved
                    @endif
                </td>
                <td style="font-size: 10px;" class="p-2">"{{$data['document']->gm_cons_komentar}}"</td>
                <td style="font-size: 10px;" class="p-2"></td>
            </tr>
            <tr class="border border-gray-800">
                <td style="font-size: 10px;" class="fw-bolder p-2">MGR Procurement Status</td>
                <td style="font-size: 10px;" class="p-2">{{$data['document']->mgr_proc_name1}}<br>{{$data['document']->mgr_proc_nik}}<br>{{$data['document']->mgr_proc_posisi1}}</td>
                <td style="font-size: 10px;" class="p-2">
                    @if ($data['document']->mgr_proc_date != NULL)
                    APPROVED
                    @else
                    NY APPROVED
                    @endif
                </td>
                <td style="font-size: 10px;" class="p-2">
                    @if ($data['document']->mgr_proc_date != NULL)
                    {{$data['document']->mgr_proc_date}}
                    @else
                    NY Approved
                    @endif
                </td>
                <td style="font-size: 10px;" class="p-2">"{{$data['document']->mgr_proc_komentar}}"</td>
                <td style="font-size: 10px;" class="p-2">Nilai Final: @php echo number_format($data['document']->amount_proc, 0, ',', '.');@endphp </td>
            </tr>
            <tr class="border border-gray-800">
                <td style="font-size: 10px;" class="fw-bolder p-2">VP Procurement Status</td>
                <td style="font-size: 10px;" class="p-2">{{$data['document']->vp_proc_name1}}<br>{{$data['document']->vp_proc_nik}}<br>{{$data['document']->vp_proc_posisi1}}</td>
                <td style="font-size: 10px;" class="p-2">
                    @if ($data['document']->vp_proc_date != NULL)
                    APPROVED
                    @else
                    NY APPROVED
                    @endif
                </td>
                <td style="font-size: 10px;" class="p-2">
                    @if ($data['document']->vp_proc_date != NULL)
                    {{$data['document']->vp_proc_date}}
                    @else
                    NY Approved
                    @endif
                </td>
                <td style="font-size: 10px;" class="p-2">"{{$data['document']->vp_proc_komentar}}"</td>
                <td style="font-size: 10px;" class="p-2"></td>
            </tr>
            <tr class="border border-gray-800">
                <td style="font-size: 10px;" class="fw-bolder p-2">Solution Engineering Status (PR Done)</td>
                <td style="font-size: 10px;" class="p-2">{{$data['document']->se_name1}}<br>{{$data['document']->se_nik}}<br>{{$data['document']->se_posisi1}}</td>
                <td style="font-size: 10px;" class="p-2">
                    @if ($data['document']->se_date != NULL)
                    APPROVED
                    @else
                    NY APPROVED
                    @endif
                </td>
                <td style="font-size: 10px;" class="p-2">
                    @if ($data['document']->se_date != NULL)
                    {{$data['document']->se_date}}
                    @else
                    NY Approved
                    @endif
                </td>
                <td style="font-size: 10px;" class="p-2">"{{$data['document']->se_komentar}}"</td>
                <td style="font-size: 10px;" class="p-2"></td>
            </tr>
            <tr class="border border-gray-800">
                <td style="font-size: 10px;" class="fw-bolder p-2">Officer Procurement Status (PO Done)</td>
                <td style="font-size: 10px;" class="p-2">{{$data['document']->off_proc_name1}}<br>{{$data['document']->off_proc_nik}}<br>{{$data['document']->off_proc_posisi1}}</td>
                <td style="font-size: 10px;" class="p-2">
                    @if ($data['document']->off_proc_date != NULL)
                    APPROVED
                    @else
                    NY APPROVED
                    @endif
                </td>
                <td style="font-size: 10px;" class="p-2">
                    @if ($data['document']->off_proc_date != NULL)
                    {{$data['document']->off_proc_date}}
                    @else
                    NY Approved
                    @endif
                </td>
                <td style="font-size: 10px;" class="p-2">"{{$data['document']->off_proc_komentar}}"</td>
                <td style="font-size: 10px;" class="p-2"></td>
            </tr>
            <tr>
                <td colspan="5" class="fs-4">Link ke Aplikasi: {{ url('/dashboard/list_document')}}/{{$data['document']->id}}</td>
            </tr>
        </tbody>
    </table>
</div>
<p id="watermark"></p>
{{-- <div class="pagebreak"></div>
<div class="custom">
</div> --}}
@stop 

@section('styles')
<style>
    @page {
        size: A4;
        margin: 0px 0px 0px 0px;
        padding: 0px 0px 0px 0px;
    }
    @media print {
        .pagebreak {
            display:block; page-break-before:always; 
        }
    }
    #watermark {
        color: rgba(128, 128, 128, 0.1);
        height: 100%;
        left: 0;
        line-height: 2;
        margin: 0;
        position: fixed;
        top: 0;
        /* transform: rotate(-30deg); */
        transform-origin: 0 100%;
        width: 100%;
        word-spacing: 10px;
        z-index: 1;
        -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Safari */
        -khtml-user-select: none; /* Konqueror HTML */
        -moz-user-select: none; /* Old versions of Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
        user-select: none; /* Non-prefixed version, currently
        supported by Chrome, Edge, Opera and Firefox */
    }
    .custom {
        display:block;
        padding:1.5cm;
        width:21cm;
        min-height:29.7cm;
        clear:both;
        /* overflow:hidden; */
        page-break-before: always;
    }
</style>
@stop 

@section('scripts')
<script>
    var textWatermark = '{{session()->get("user")->nik_tg}}';
    var fullTextWatermark = '';
    var n = 10000;
    for (var i = 0; i < n; i++) {
    fullTextWatermark+= ' ' + textWatermark;
    }
    document.getElementById('watermark').innerHTML = fullTextWatermark
    window.print();
</script>
@stop 
