<style>
    .alert-info{
        background: #2ea2dc;
        color: #fff;
    }
</style>
@if($errors->any())
    <ul class="c-alert c-alert--danger alert u-mb-medium" style="list-style: none;">
        @foreach($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach
    </ul>

@endif
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <div class="c-alert c-alert--{{ $msg }} alert u-mb-medium">


                <div class="">
                    <p>{!!  Session::get('alert-' . $msg)  !!}</p>
                </div>

                <button class="c-close" data-dismiss="alert" type="button">×</button>
            </div>
        @endif
    @endforeach
</div>