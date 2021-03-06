@extends('layout/main')

@section('title', 'Report Data')

@section('container')
<div class="container border rounded my-2">
    <div class="col-8">
        <h3>Filter</h3>
        <form action="">
            <div id="divkab">
                <label for="kablist" class="">Kabupaten/kota</label>
                <input class=" form-control" list="kaboption" id="kablist" placeholder="Type to search..." name="kab"
                    autocomplete="off">
                <datalist id="kaboption">
                    <option value="1600" selected>Semua</option>
                    @foreach ($kabkotlist as $kabkot)
                    <option value={{ $kabkot->id_kab }} selected>{{ $kabkot->nm_kab }}</option>
                    @endforeach
                </datalist>
            </div>

            <div id="divpetugas">
                <label for="petugaslist" class="">Petugas</label>
                <input class=" form-control" list="petugasoption" id="petugaslist" placeholder="Type to search..."
                    name="petugas" autocomplete="off">
                <datalist id="petugasoption">
                    <option value="0" selected>Semua</option>
                    @foreach ($petugass as $petugas)
                    <option value={{ $petugas->kode }} selected>{{ $petugas->nm_petugas }}</option>
                    @endforeach
                </datalist>
            </div>

            <div id="divnks">
                <label for="nkslist" class="">NKS</label>
                <input class=" form-control" list="nksoption" id="nkslist" placeholder="Cari NKS.." name="nks"
                    autocomplete="off">
                <datalist id="nksoption">
                    <option value="0" selected>Semua</option>
                    @foreach ($nkss as $nks)
                    <option value={{ $nks->nks }} selected></option>
                    @endforeach
                </datalist>
            </div>
            <div class="d-flex justify-content-end m-1">
                <button type="submit" class="btn btn-primary btn-lg  my-2">Submit</button>
            </div>
        </form>
    </div>

    <div class="container border rounded my-2">
        <h3>Bar Chart</h3>
        <canvas id="myChart" height="20vh" width="60vw"></canvas>
        {{-- <canvas id="myChart2" height="20vh" width="60vw"></canvas> --}}
        <div class="d-flex  justify-content-between">
            <h3>Tabel</h3>
            <a class="btn btn-success btn-sm" id="downloadbtn">Download</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    @if ($request->nks != null && $request->nks != '0')
                    <th scope="col">Waktu</th>
                    @else
                    @if ($request->petugas != null && $request->petugas != '0')
                    <th scope="col">NKS</th>
                    @else
                    @if ($request->kab != null && $request->kab != '0')
                    <th scope="col">NKS</th>
                    @else
                    <th scope="col">Nama Kabupaten</th>
                    @endif
                    @endif
                    @endif
                    <th scope="col">Dokumen Diterima</th>
                    <th scope="col">Dokumen Diserahkan</th>

                    @if ($request->nks != null && $request->nks != '0')
                    <th scope="col">Deskripsi</th>
                    @else
                    @if ($request->petugas != null && $request->petugas != '0')
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Update Terakhir</th>
                    @else
                    @if ($request->kab != null && $request->kab != '0')
                    <th scope="col">Deskripsi</th>
                    <th scope="col">PML</th>
                    <th scope="col">Update Terakhir</th>
                    @else
                    <th scope="col">Update Terakhir</th>
                    @endif
                    @endif
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $key => $data)
                <tr>
                    <th scope="row">{{ $key }}</th>
                    <td>{{ $data->nama }}</td>
                    <td>{{ $data->dok_diterima }}</td>
                    <td>{{ $data->dok_diserahkan }}</td>
                    @if ($request->nks != null && $request->nks != '0')
                    <td>{{ $data->deskripsi }}</td>
                    @else
                    @if ($request->petugas != null && $request->petugas != '0')
                    <td>{{ $data->deskripsi }}</td>
                    <td>{{ $data->updated_at }}</td>
                    @else
                    @if ($request->kab != null && $request->kab != '0')
                    <td>{{ $data->deskripsi }}</td>
                    <td>{{ $data->pml }}</td>
                    <td>{{ $data->updated_at }}</td>
                    @else
                    <td>{{ $data->updated_at }}</td>
                    @endif
                    @endif
                    @endif

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<script>
    $(".report").addClass("active");
        var request = {!! json_encode($request->toArray()) !!};
        if (request.kab != null || request.kab != '1600') {
            $('#kablist').val(request.kab);
        }
        if (request.petugas != null || request.petugas != '0') {
            $('#petugaslist').val(request.petugas);
        }
        if (request.nks != null || request.nks != '0') {
            $('#nkslist').val(request.nks);
        }

        var ctx = document.getElementById('myChart').getContext('2d');
        if (request.nks != null && request.nks != '0') {
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode(array_reverse($arraykab)) !!},
                    datasets: [{
                        label: 'dokumen diterima',
                        data: {!! json_encode(array_reverse($arraydok_terima)) !!},
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.3)',
                            'rgba(54, 162, 235, 0.3)',
                            'rgba(255, 206, 86, 0.3)',
                            'rgba(75, 192, 192, 0.3)',
                            'rgba(153, 102, 255, 0.3)',
                            'rgba(255, 159, 64, 0.3)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }, {
                        label: 'Dokumen diserahkan',
                        data: {!! json_encode(array_reverse($arraydok_serah)) !!},
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                            'rgba(255, 159, 64, 0.6)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }, ]
                }
            });
        } else {
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($arraykab) !!},
                    datasets: [{
                            label: 'dokumen diterima',
                            data: {!! json_encode($arraydok_terima) !!},
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.3)',
                                'rgba(54, 162, 235, 0.3)',
                                'rgba(255, 206, 86, 0.3)',
                                'rgba(75, 192, 192, 0.3)',
                                'rgba(153, 102, 255, 0.3)',
                                'rgba(255, 159, 64, 0.3)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        },
                        {
                            label: 'Dokumen diserahkan',
                            data: {!! json_encode($arraydok_serah) !!},
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(255, 206, 86, 0.6)',
                                'rgba(75, 192, 192, 0.6)',
                                'rgba(153, 102, 255, 0.6)',
                                'rgba(255, 159, 64, 0.6)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        },
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            stacked: true
                        }
                    }
                }
            });
        }
        $('#downloadbtn').click(function(){
           var request = {!! json_encode($request->toArray()) !!}
           console.log(request)
           var kd_kab = "";
           var nks = "";
           var petugas = "";
           if(request.kab != null && request.kab != '1600'){
            kd_kab = request.kab
           }else{
            kd_kab = "{{session('kode_kab')}}"
           }
           if(request.petugas != null && request.petugas != '0'){
            petugas = request.petugas
           }else{
            petugas = ""
           }
           if(request.nks != null && request.nks != '1600'){
            nks = request.nks
           }else{
            nks = ""
           }
        //    console.log(kd_kab)
           window.location.href = "downloadreport?kab="+kd_kab+"&petugas="+ petugas+
           "&nks="+ nks
        })
</script>
@endsection

@section('style')
<style>
    select.form-control {
        display: inline-block
    }

    option {
        /* width: 100px; */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@endsection
