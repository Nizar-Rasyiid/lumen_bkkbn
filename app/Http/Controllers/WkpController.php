<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\WkpStorePost;

use App\Models\Perusahaan;
use App\Models\PerusahaanAkta;
use App\Models\Narahubung;
use App\Models\Ipb;
use App\Models\Wkp;
use App\Models\WkpLokasi;
use App\Models\Provinsi;
use App\Models\Kota;

class WkpController extends Controller
{
    public function create()
    {
        $provinsi_list = Provinsi::orderBy('nama')->get();
        $kota_list = Kota::orderBy('nama')->get();
        return view('wkp.create', compact('provinsi_list', 'kota_list'));
    }

    public function store(WkpStorePost $request)
    {
        $perusahaan = session('perusahaan');

        if ($perusahaan['id'] == null) {
            $perusahaan = session('perusahaan');
            $perusahaan->save();

            $narahubung = session('narahubung');
            $perusahaan->narahubung()->save($narahubung);

            $perusahaan_akta = session('perusahaan_akta');
            $perusahaan->akta()->save($perusahaan_akta);
        }

        $ipb = session('ipb');
        $perusahaan->ipb()->save($ipb);

        $wkp = new Wkp;
        $wkp->nama_wkp   = $request->nama_wkp;
        $wkp->nomor_sk   = $request->nomor_sk_wkp;
        $wkp->tanggal_sk = $request->tanggal_sk_wkp;

        // dapatkan id perusahaan
        $perusahaan->nama = $perusahaan['nama'];

        if ($request->file('dokumen_sk_wkp')) {
            $wkp->file_sk = $request->file('dokumen_sk_wkp')->getClientOriginalName();
            $file_sk_wkp_path = $request->file('dokumen_sk_wkp')->storeAs($perusahaan->nama.'/WKP/FILE_SK', $wkp->file_sk, 'public');
        }

        if ($request->file('dokumen_berita_acara_pdp')) {
            $wkp->file_ba_usulan_dbh = $request->file('dokumen_berita_acara_pdp')->getClientOriginalName();
            $file_ba_pdp_path = $request->file('dokumen_berita_acara_pdp')->storeAs($perusahaan->nama.'/WKP/FILE_BA_USULAN_DBH', $wkp->file_ba_usulan_dbh, 'public');
        }

        $ipb->wkp()->save($wkp);

        foreach ($request->wilayahWKP as $key => $wkp_val) {
            if ($wkp_val['provinsi'] != '' ||
          $wkp_val['kabkot'] != '' ||
          $wkp_val['pdp'] != '' ||
          $wkp_val['luas_wilayah'] != ''
        ) {
                $wkp_lokasi = new WkpLokasi;
                $wkp_lokasi->provinsi_id  = $wkp_val['provinsi'];
                $wkp_lokasi->kota_id      = $wkp_val['kabkot'];
                $wkp_lokasi->pdp          = $wkp_val['pdp'];
                $wkp_lokasi->luas_wilayah = $wkp_val['luas_wilayah'];
                $wkp->wkp_lokasi()->save($wkp_lokasi);
            }
        }

        $request->session()->forget('perusahaan');
        $request->session()->forget('perusahaan_akta');
        $request->session()->forget('narahubung');
        $request->session()->forget('ipb');

        return redirect()->route('perusahaan.index')->with('status_success', 'Registrasi Perusahaan berhasil dibuat.');
    }
}
