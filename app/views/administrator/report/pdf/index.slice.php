<style type="text/css">
    table,
    th,
    td {
        vertical-align: top;
        font-size: 20px;
        padding: 2px;
    }
    .text-small{
        font-size: 14px;
    }

    .text-justify {
        text-align: justify;
    }

    .text-center {
        text-align: center;
    }

    .text-left {
        text-align: left;
    }

    .text-right {
        text-align: right;
    }

    .big,
    .big {
        font-size: 250%;
        font-weight: 400;
        padding: 100px 0 100px 0;
    }

    .ptpb-5 {
        padding: 5px 0 50px 0;
    }
    .tbl-border-collapse table{
        
    }
    .tbl-border table{
        
        border: 1px solid black;
    }
    .tbl-border th{
        border: 1px solid black;
    }
    .tbl-border td{
        border: 1px solid black;
    }
</style>
<table width="100%">
    <tr>
        <td width="100%" class="text-center" colspan="7">LAPORAN PEMINJAMAN PERANGKAT</td>
    </tr>
    <tr>
        <td width="100%" class="text-justify" colspan="7">BULAN : {{ $rs_search['bulan'] }}</td>
    </tr>
    <tr>
        <td width="100%" class="text-justify" colspan="7">TAHUN : {{ date('Y') }}</td>
    </tr>
</table>
<br />
<table width="100%" class="tbl-border">
    <thead>
        <tr>
            <th width="5%" class="text-justify" >#</th>
            <th width="15%" class="text-justify" >KODE PENGAJUAN</th>
            <th width="20%" class="text-justify" >NAMA PEMINJAM</th>
            <th width="20%" class="text-justify" >KEPERLUAN</th>
            <th width="20%" class="text-justify" >STATUS PEMINJAMAN</th>
            <th width="20%" class="text-justify" >Update Terakhir</th>
        </tr>
    </thead>
    <tbody>
        @php $no  = 1 @endphp
        @forelse ($result as $item)
        <tr>
            <td width="5%" class="text-justify">{{$no++}}</td>
            <td width="15%" class="text-justify">{{$item['peminjaman_kode']}}</td>
            <td width="20%" class="text-justify">{{$item['peminjam']}}</td>
            <td width="20%" class="text-justify">{{$item['penggunaan_keperluan']}}</td>
            <td  width="20%" class="text-justify">
                @if ($item['peminjaman_st'] == 'draft')
                <span for="" class="badge badge-info badge-sm">DRAFT</span>
                @elseif($item['peminjaman_st'] == 'process')
                <span for="" class="badge badge-primary badge-sm">DIPROSES</span>
                @elseif($item['peminjaman_st'] == 'approved')
                <span for="" class="badge badge-success badge-sm">DISETUJUI</span>
                @elseif($item['peminjaman_st'] == 'rejected')
                <span for="" class="badge badge-danger badge-sm">DITOLAK</span>
                @elseif($item['peminjaman_st'] == 'returned')
                <span for="" class="badge badge-secondary badge-sm">DIKEMBALIKAN</span>
                <br>
                <small>{{$this->tdtm->get_full_date($item['returned_at'],'ins')}}</small>
                @endif
            </td>
            <td width="20%">{{$this->tdtm->get_full_date($item['mdd'],'ins') ?? '-' }}</td>
        </tr>
        @empty
        @endforelse
    </tbody>
</table>
<table width="100%">
    <hr>
    <tr>
        <td width="90%" class="text-justify text-small" colspan="7"> Dicetak oleh {{ $com_user['full_name']}} dari Sistem Informasi Peminjaman Balmon I Yogyakarta pada 3 September 2020 Jam 1:40 PM </td>
    </tr>
</table>
