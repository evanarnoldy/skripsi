<a href="{{route('detail.tanggapan',$notif->data['tanggapan'][0]['id'])}}" class="nama-ses bot">
    <p class="font-italic">{{date('l, d F Y H:i:s', strtotime($notif->data['tanggapan'][0]['created_at']))}} <strong>Ada pesan masuk</strong></p>
</a>

