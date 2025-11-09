<!DOCTYPE html>
<html lang="en">
<head>
  <title>Email</title>
  <meta charset="utf-8">
  <style>
    @import url('https://fonts.googleapis.com/css?family=Roboto&display=swap');

    html, body {
      height: 100% !important;
    }

    table {
      border-spacing: 0;
      border-collapse: collapse;
    }
  </style>
</head>

<body style="margin: 0; padding: 0;">
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" bgcolor="#f2f2f2">
    <tr>
      <td valign="center">
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="1000" bgcolor="#fff">
            <tr>
              <td style="margin:0; padding:20px; background-color:#0a3e99;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                    <td>
                      <a href="javascript:;">
                        <img width="70" src="<?= asset('assets/logo-white.svg') ?>" alt="">
                      </a>
                    </td>

                    <td align="right" style="font-size: 30px; font-weight: bold; letter-spacing: 2px; color:#fff; font-family: 'Roboto', sans-serif;">{{ config('settings.EMAIL_TEMPLATE_HEADER_TEXT') }}</td>
                  </tr>
                </table>
              </td>
            </tr>

            <tr>
              <td style="margin: 0; padding: 30px 20px; font-size: 16px; line-height: 1.2; color:#333; font-family: 'Roboto', sans-serif;">
               @yield('content')



              </td>
            </tr>

            <tr>
              <td align="center" style="margin: 0; padding:10px 20px; font-size: 18px; color:#fff; background-color:#0a3e99; font-family: 'Roboto', sans-serif;">
              </td>
            </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>




