@php 
    header("Content-Type: text/csv");
	header("Content-Disposition: attachment; filename=Export All Project SPMK.csv");
    echo "NO;NOMOR BOQ;PROJECT ID;SITE NAME;REGION;SCOPE OF WORK;AMOUNT;SUPPLIER NAME;SPMK;AMOUNT AWAL;AMOUNT FINAL;SOW;STATUS";
    foreach($data['sow'] as $s){
        echo ";NILAI AWAL ".$s->sow.";NILAI FINAL ".$s->sow;
    }
    echo "\r\n";
    foreach($data['document'] as $key => $req){
        $no = $key + 1;
        $req->nomor_boq = trim(str_replace(array("\n", ';', "\r"), '', $req->nomor_boq));
        $req->pid = trim(str_replace(array("\n", ';', "\r"), '', $req->pid));
        $req->site_name = trim(str_replace(array("\n", ';', "\r"), '', $req->site_name));
        $req->region = trim(str_replace(array("\n", ';', "\r"), '', $req->region));
        $req->scope = trim(str_replace(array("\n", ';', "\r"), '', $req->scope));
        $req->amount = trim(str_replace(array("\n", ';', "\r"), '', $req->amount));
        $req->supplier_name = trim(str_replace(array("\n", ';', "\r"), '', $req->supplier_name));
        $req->spmk = trim(str_replace(array("\n", ';', "\r"), '', $req->spmk));
        $req->amount_awal = trim(str_replace(array("\n", ';', "\r"), '', $req->amount_awal));
        $req->amount_proc = trim(str_replace(array("\n", ';', "\r"), '', $req->amount_proc));
        $req->sow = trim(str_replace(array("\n", ';', "\r"), '', $req->sow));
        $req->status = trim(str_replace(array("\n", ';', "\r"), '', $req->status));
        echo $no.';'.$req->nomor_boq.';'.$req->pid.';'.$req->site_name.';'.$req->region.';'.
             $req->scope.';'.$req->amount.';'.$req->supplier_name.';'.$req->spmk.';'.$req->amount_awal.';'.
             $req->amount_proc.';'.$req->sow.';'.$req->status;
        foreach($data['sow'] as $s){
            echo ';'.$data['nilai_awal_sow'][$req->id][$s->id].';'.$data['nilai_final_sow'][$req->id][$s->id];
        }
        echo "\r\n";
        // break;
    }
@endphp
