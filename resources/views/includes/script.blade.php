<script src="{{asset('assets/js/jQuery.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/bootstrap.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/lobibox/js/lobibox.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/jquery.validate.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/password-policy.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/custom.js')}}" type="text/javascript"></script>

<script type="text/javascript">
var BASEURL = "{{url('/')}}";
var BASEURLMAINDOMAIN = "{{rewriteRoute(url('/'))}}";

function showMesseage(type, message){
    if(type=='success')
    {
        Lobibox.notify('success', {
	        pauseDelayOnHover: true,
	        continueDelayOnInactiveTab: false,
            position: 'center top',
            msg: message
    });
    }
    if(type=='error')
    {
        Lobibox.notify('error', {
            pauseDelayOnHover: true,
            continueDelayOnInactiveTab: false,
            position: 'center top',
            msg: message
    });
    }

}
</script>
<style type="text/css">
.lobibox-notify-msg{max-height:100px !important;}
</style>
@yield('uniquepagescript')
