@if(isset($errors))
    @if ($errors->any())
        <script>
         $(function () {
                (function () {

                    var elmnt = document.getElementById("contact_form_div");
                    elmnt.scrollIntoView();
                    Lobibox.notify('error', {
                        rounded: false,
                        delay: 4000,
                        delayIndicator: true,
                        msg: "<?php foreach($errors->all() as $error){ echo $error."<br>"; } ?>"
                    });
                })();
            });
        </script>
    @endif
@endif
    @if(session()->has('success') or session()->has('warning') or session()->has('info') or session()->has('danger') or session()->has('error')  or session()->has('status'))
        @foreach (['danger', 'warning', 'success', 'info','error','status'] as $msg)
            @if(session()->has($msg))

                <script>
                var msgType = "{{@$msg}}";
                if(msgType=='status')
                {
                    msgType = 'success';
                }
                 $(function () {
                        (function () {
                            Lobibox.notify(msgType, {
                                rounded: false,
                                delay: 4000,
                                delayIndicator: true,
                                msg: "{{ session()->get(@$msg)}}"
                            });
                        })();
                    });
                </script>
                <?php  session()->forget(@$msg); ?>
            @endif
        @endforeach
    @endif