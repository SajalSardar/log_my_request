<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket Infos</title>
</head>

<body style="margin: 0; padding: 0; width: 100%;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; padding: 20px; border: 1px solid gray; border-radius: 20px; text-align: center;">
                    <tr>
                        <td style="padding-bottom: 16px;">
                            <h4 style="font-weight: 900; margin: 0;">Log My Request</h4>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="text-align: left; margin-bottom: 20px;">
                                <h4 style="font-weight: 600; margin: 0;">Ticket Infos:</h4>
                                <p>Requester name: {{ $ticket?->requester_name }}</p>
                                <p>Ticket Title : {{ $ticket?->request_title }}</p>
                                <p>Ticket Description: {{ $ticket?->request_description }}</p>
                                <p>Due Date: {{ Helper::ISODate($ticket?->due_date) }}</p>
                            </div>
                        </td>
                    </tr>
                    @if ($ticket->credentials == '1')
                    <tr>
                        <td>
                            <div style="text-align: left;">
                                <h4 style="font-weight: 600; margin: 0;">Your credentials:</h4>
                                <p>Email : {{ $ticket?->requester_email }}</p>
                                <p>Phone : {{ $ticket?->requester_phone }}</p>
                                <p>Password : {{ $ticket?->password }}</p>
                                <span style="color:red; font-size: 12px;">Please don't share your credentials with others.</span>
                            </div>
                        </td>
                    </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>
</body>


</html>