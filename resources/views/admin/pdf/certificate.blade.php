<!DOCTYPE html>
<html>

<head>
    <title>CERTIFICATE FOR VISUAL STANDARDS FOR DRIVING</title>
    <style>
        p {
            font-size: small;
        }

        .photo {
            height: 200px;
            border: 1px solid #000;
            text-align: center;
        }

        small {
            font-size: 10px !important;
        }

        .text-center {
            text-align: center;
        }

        .bordered {
            border: 1px solid #000;
        }

        .bordered td {
            border: 1px solid #000;
        }

        .text-end {
            text-align: right;
        }
    </style>
</head>

<body>
    <center>
        <h4><u>CERTIFICATE FOR VISUAL STANDARDS FOR DRIVING</u></h4>
        <p>(To be filled in by Registered Ophthalmology)</p>
    </center>
    <br />
    <table width="100%">
        <tr>
            <td width="75%" valign="top">
                <p>I have examined Shri/Smt <strong>{{ strtoupper($mrecord->name) }}</strong> Aged <strong>{{ $mrecord->age.strtoupper(' YEARS') }}</strong> and his/her visual standards are as follows:</p>
                <p>Photograpgh of the candidate</p>
                <p>(To be signed upon by the Ophthalmologist)</p>
                <br />
                <br />
                <br />
                <p>I. Visual Acuity</p>
            </td>
            <td>
                <div class="photo"><small>Affix Passport size recent Colour photograph</small></div>
            </td>
        </tr>
    </table>
    <table class="bordered" width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td class="text-center">Visual<br />Acuity</td>
            <td class="text-center">A<br />Unaided</td>
            <td class="text-center">B<br />Corrected</td>
            <td class="text-center">Sph</td>
            <td class="text-center">Cyl</td>
            <td class="text-center">Axis</td>
            <td class="text-center">C<br />Binocular<br />Corrected</td>
        </tr>
        <tr>
            <td class="text-center">RE</td>
            <td><br /><br /></td>
            <td><br /><br /></td>
            <td><br /><br /></td>
            <td><br /><br /></td>
            <td><br /><br /></td>
            <td><br /><br /></td>
        </tr>
        <tr>
            <td class="text-center">LE</td>
            <td><br /><br /></td>
            <td><br /><br /></td>
            <td><br /><br /></td>
            <td><br /><br /></td>
            <td><br /><br /></td>
            <td><br /><br /></td>
        </tr>
    </table>
    <br />
    <p>II. Night blindness..................................................................................................................................</p>
    <p>III. Squint..................................................................................................................................</p>
    <p>IV. Field (Degrees) Horizontal...............................................Vertical...........................................................</p>
    <p>V. Fundus...............................................RE...........................................LE......................................</p>
    <p>Any other significant ocular morbidity...............................................................................</p>
    <br />
    <table>
        <tr>
            <td>Candidate is <strong>Fit</strong></td>
            <td><input type="checkbox" /></td>
            <td>/</td>
            <td><strong>Unfit</strong></td>
            <td><input type="checkbox" /></td>
            <td>to drive a Category I/II vehicle.</td>
    </table>
    <p>Unfit due to criteria....................................................................................................mentioned above. (Category-I means Non Transport Vehicles which include Motor Cycles, Motor Cars, etc. specified as such in Central Government Notification No.S.O.1248(E) dated 5th November 2004 as non-transport vehicles)
    </p>
    <p>(Category-II means transport vehicles which include Autorikshaws, Taxis, Stage carriages, Contract carriages,
        Goods carriages, Private Vehicles etc. specified as such in the said Notification.)</p>
    <br />
    <table width="100%">
        <tr>
            <td>Signature of the candidate:</td>
            <td class="text-end">Signature of Ophthalmologist:</td>
        </tr>
        <tr>
            <td>Place:</td>
            <td></td>
        </tr>
        <tr>
            <td>Date:</td>
            <td class="text-end">(Seal)</td>
        </tr>
    </table>
    <div class="text-center">
        @if($qrcode)
        <img src="data:image/png;base64, {!! $qrcode !!}">
        <p>{{ $mrecord->mrn }}</p>
        @endif
    </div>
</body>

</html>