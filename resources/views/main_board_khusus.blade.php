@extends('layouts.blank')

@section('title', 'Main Board')

@section('contents')
<div class="d-flex flex-column flex-column-fluid flex-row-fluid bgi-position-y-top position-x-center bgi-no-repeat bgi-size-cover bgi-attachment-fixed" style="background-image: url({{ asset('assets/img/background.png')}})">
    <div class="d-flex flex-column flex-column-auto">
        <div class="text-center d-flex flex-column justify-content-center" style="padding: 5px; background-color: #ae0000;">
            <h2 class="fw-bolder text-white" style="margin-bottom:5px;">Radir Khusus Mitratel</h2>
            <h4 class="text-white">{{$data['date']}} <a href="{{ url('/dashboard') }}" class="text-muted">Back to Dashboard</a></h4>
        </div>
    </div>
    <div class="d-flex flex-column flex-column-fluid p-5">
        <div class="d-flex flex-row flex-column-fluid">
            <div class="d-flex flex-row-auto">
                <div class="bg-body rounded shadow-sm p-10 mx-auto w-250px">
                    <h1 style="overflow-wrap: break-word;">Scan disini untuk absen:</h1>
                    <img src="{{ asset('assets/img/qrcodenoads.png') }}?dummy=<?php echo time() ?>" class="h-150px">
                    <h2 class="my-5" style="overflow-wrap: break-word;">Atau masukkan URL dibawah ini:</h2>
                    <div class="bg-secondary my-5" style="padding: 5px;">
                        <h6 style="overflow-wrap: break-word; font-size: 11px;">tinyurl.com/AbsenNewRadir</h6>
                    </div>
                    <div class="bg-secondary detail-absen" style="padding: 5px; height: 200px; overflow-y:scroll;">
                        <h6>Hadir: 0</h6>
                        <h6>Belum Absen: 0</h6>
                        <h6>Tidak Hadir/Izin: 0</h6>
                        <h6>Alasan:</h6>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-row-fluid">
                <div class="d-flex flex-wrap">
                    @foreach($data['peserta'] as $peserta)
                    <div class="bg-body rounded shadow-sm" style="padding:10px; margin: 2px 2px; height: 155px !important; width: 95px !important;">
                        @if ($peserta->photo != NULL)
                        <img src="{{ asset('eviden') }}/{{$peserta->photo}}" style="height: 75px; width: 75px;">
                        @else
                        <img src="{{ asset('assets/media/svg/avatars/blank.svg')}}" style="height: 75px; width: 75px;">
                        @endif
                        <div class="overlay-custom overlay-{{$peserta->id}}"></div>
                        <div class="name-custom"><span>{{$peserta->name}}</span></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<style>
    .overlay-custom {
        position: relative; /* Sit on top of the page content */
        width: 100%; /* Full width (cover the whole page) */
        height: 75px; /* Full height (cover the whole page) */
        top: -75px;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0,0,0,0.85); /* Black background with opacity */
        z-index: 1000; /* Specify a stack order in case you're using a different order for other elements */
    }
    .name-custom {
        position:relative;
        width: 75px !important;
        top:-75px;
        font-size: 12px;
    }
    .hidden {
        background-color: rgba(0,0,0,0) !important;
    }
    .tidak_hadir {
        background-color: rgba(255,0,0,0.5) !important;
    }
</style>
@stop

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toastr-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "1000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    jQuery(document).ready(function() {
        var intervalId = window.setInterval(function(){
            $.ajax({
                url: '{{ url("/api/get_absen_khusus")}}',
                method: 'GET',
                success : function(res) {
                    var hadir = 0;
                    var tidak_hadir = 0;
                    var belum_absen = 0;
                    var alasan = '';
                    res.forEach(absenPeserta);
                    $('.detail-absen').html('<h6>Hadir: ' + hadir + '</h6>\
                    <h6>Belum Absen: ' + belum_absen + '</h6>\
                    <h6>Tidak Hadir/Izin: ' +  tidak_hadir + '</h6>\
                    <h6>Alasan:</h6>' + 
                    alasan);
                    function absenPeserta(res) {
                        id = res.id;
                        if (res.hadir_count == 1){
                            if (!$('.overlay-' + id).hasClass('hidden')){
                                $('.overlay-' + id).addClass('hidden');
                            }
                            if ($('.overlay-' + id).hasClass('tidak_hadir')){
                                $('.overlay-' + id).removeClass('tidak_hadir');
                            }
                            hadir++;
                        } else if (res.tidak_hadir_count == 1){
                            if ($('.overlay-' + id).hasClass('hidden')){
                                $('.overlay-' + id).removeClass('hidden');
                            }
                            if (!$('.overlay-' + id).hasClass('tidak_hadir')){
                                $('.overlay-' + id).addClass('tidak_hadir');
                            }
                            tidak_hadir++;
                            alasan = alasan + '<span>' + res.name + ' : '+ res.alasan + '</span><br>';
                        } else {
                            if ($('.overlay-' + id).hasClass('hidden')){
                                $('.overlay-' + id).removeClass('hidden');
                            }
                            if (!$('.overlay-' + id).hasClass('tidak_hadir')){
                                $('.overlay-' + id).removeClass('tidak_hadir');
                            }
                            belum_absen++;
                        }
                    }
                },
                error : function (e) {
                    console.log(e);
                    toastr.error("Refresh Absen Error", "Error");
                    // $.alert({
                    //     title: 'Error!',
                    //     content: 'Refresh Absen Failed',
                    // });
                }
            });
        }, 1000);
    });
</script>  
@stop 
