@if (session('info'))
    @foreach(session('info') as $title => $message)
      <div class="alert alert-info alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <b>{{ $title }}</b>
        <p>{{ $message }}</p>
      </div>
  @endforeach
@endif
@if (session('success'))
    @foreach(session('success') as $title => $message)
      <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <b>{{ $title }}</b>
        <p>{{ $message }}</p>
      </div>
  @endforeach
@endif
@if (session('error'))
    @foreach(session('error') as $title => $message)
      <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <b>{{ $title }}</b>
        <p>{{ $message }}</p>
      </div>
  @endforeach
@endif
@if (session('warning'))
    @foreach(session('warning') as $title => $message)
      <div class="alert alert-warning alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <b>{{ $title }}</b>
        <p>{{ $message }}</p>
      </div>
  @endforeach
@endif
