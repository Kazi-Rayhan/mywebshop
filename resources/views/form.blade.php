<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        span {
            display: inline-block;
            vertical-align: top;
            /* Aligns the span elements vertically */
        }

        input[type="checkbox"] {
            display: inline-block;
            vertical-align: middle;
            /* Aligns the checkbox vertically */
        }

        label {
            display: inline-block;
            font-size: 12px;
            vertical-align: middle;
            /* Aligns the label vertically */
        }
    </style>

</head>

<body>

    <table style="width: 100%;background: blue;">
        <thead>
            <tr>
                <td style="color: white; font-weight: 600;">Selskapsinformasjon</td>
                <td style="color: white;">1</td>
            </tr>
        </thead>
    </table>


    <!-- div -->
    <div style="height: 55px; background: #fff; border-bottom: 1px solid rebeccapurple;">
        <div style="border-right: 1px solid black; width: 20%; float: left; height: 100%;">
            <label style="font-size: 12px">*Ny søknad Sentralavtale Endring av juridisk enhet </label>
            <div>
                <span> <input type="checkbox" name="" id="" checked></span>
                <span> <input type="checkbox" name="" id=""></span>
                <span> <input type="checkbox" name="" id=""></span>
            </div>
        </div>
        <div style="border-right: 1px solid black;float: left;  height: 100%;width:12%">
            <label style="font-size: 12px;">*Portefølje</label>
            <div>
                <input style="background:none;border:none;font-size:12px" type="text" value="Nordic">
            </div>
        </div>
        <!-- search -->
        <div style="border-right: 1px solid black;float: left;padding-left: 2px;height: 100%;width:12% ">
            <label style="font-size: 12px">*Porteføljeland</label>
            <div>
                <input style="background:none;border:none;font-size:12px" type="text" value="Norge">
            </div>
        </div>
        <!-- search -->
        <!-- div -->
        <div style="border-right: 1px solid black;float: left; padding-left: 2px; height: 100%; ">
            <span style="font-size: 12px">Kunde besøkt?</span>
            <div style="width:100%">
                <input type="checkbox" name="" id="">
                <label for="" style="font-size: 12px">Ja</label>
                <span>
                    <input type="checkbox" name="" id="">
                    <label for="" style=" font-size: 12px">N/A</label>
                </span>
            </div>
        </div>
        <div style="border-right: 1px solid black;float: left; padding-left: 2px; height: 100%;width:8%; ">
            <span style="font-size: 12px">*Valuta</span>
            <div style="width:100%">
                <input type="text" name="" id="" value="NOK" readonly
                    style="border:0;background:none;font-size:12px">
            </div>
        </div>
        <div style="border-right: 1px solid black;float: left; padding-left: 2px; height: 100%;width:15% ">
            <span style="font-size: 12px">*CLG valutagruppe</span>
            <div style="width:100%">
                <input type="text" name="" id="" value="481" readonly
                    style="border:0;background:none;font-size:12px">
            </div>
        </div>
        <div style="border-right: 1px solid black;float: left; padding-left: 2px; height: 100%;width:10% ">
            <span style="font-size: 12px">*Kortmiks</span>
            <div style="width:100%">
                <input type="text" name="" id="" value="Nordic" readonly
                    style="border:0;background:none;font-size:12px">
            </div>
        </div>
        <div style="float: left; padding-left: 2px; height: 100%;width:10% ">
            <span style="font-size: 12px">MCC</span>
            <div style="width:100%">
                <input type="text" name="" id="" value="" readonly
                    style="border:0;background:none;font-size:12px">
            </div>
        </div>
        <!-- div -->
    </div>
    <!-- div -->

    <table style="width: 100%;background: #fff;">

    </table>

    <!-- div -->
    <div style="height: 55px; background: #fff; border-top:1px solid;border-bottom: 1px solid rebeccapurple;">
        <div style="border-right: 1px solid black; width: 20%; float: left; height: 100%;">
            <label style="font-size: 12px">Forhåndstildelt MID </label>
            <div>
                <input style="background:none;border:none;font-size:12px" type="text" value="">
            </div>
        </div>
        <div style="border-right: 1px solid black;float: left;  height: 100%;width:12%">
            <label style="font-size: 12px;">*Portefølje</label>
            <div>
                <input style="background:none;border:none;font-size:12px" type="text" value="">
            </div>
        </div>
        <!-- search -->
        <div style="border-right: 1px solid black;float: left;padding-left: 2px;height: 100%;width:15% ">
            <label style="font-size: 12px">Association kode(r)</label>
            <div>
                <input style="background:none;border:none;font-size:12px" type="text" value="">
            </div>
        </div>
        <!-- search -->
        <!-- div -->
        <div style="border-right: 1px solid black;float: left; padding-left: 2px; height: 100%; width:15%">
            <span style="font-size: 12px">Parent Chain kode</span>
            <div style="width:100%">
                <input style="background:none;border:none;font-size:12px" type="text" value="">
            </div>
        </div>
        <div style="border-right: 1px solid black;float: left; padding-left: 2px; height: 100%;width:20%; ">
            <span style="font-size: 12px">*PE-kode(Partnerkode)</span>
            <div style="width:100%">
                <input type="text" name="" id="" value=""
                    style="border:0;background:none;font-size:12px">
            </div>
        </div>
        <div style="border-right: 1px solid black;float: left; padding-left: 2px; height: 100%;width:15% ">
            <span style="font-size: 12px">*Selger ID </span>
            <div style="width:100%">
                <input type="text" name="" id="" value="7008"
                    style="border:0;background:none;font-size:12px">
            </div>
        </div>
        <!-- div -->
    </div>
    <!-- div -->
    <!-- div -->
    <div style="height: 55px; background: #fff; border-top:1px solid;border-bottom: 1px solid rebeccapurple;">
        <div style=" width: 30%; float: left; height: 100%;">
            <label style="font-size: 12px">*Distribusjon av reklamasjoner via </label>
            <div>
                <input style="background:none;border:none;font-size:12px" type="text" value="">
            </div>
        </div>
        <div style="float: left;  height: 100%;width:55%">
            <input type="checkbox" name="" id="">
            <label style="font-size: 12px;">E-post (anbefales)</label>
            <input style="background:none;border:none;font-size:12px" type="text" value="">
        </div>
        <!-- search -->
        <div style="border-right: 1px solid black;float: left; padding-left: 2px; height: 100%;width:15%">
            <div style="width:100%">
                <span>
                    <input type="checkbox" name="" id="">
                    <label style="font-size: 12px;">Online</label>
                </span>
                <span>
                    <input type="checkbox" name="" id="">
                    <label style="font-size: 12px;">Post</label>
                </span>
            </div>
        </div>
        <!-- div -->
    </div>

    <div
        style="height: 65px; background: #fff; border-top:1px solid;border-bottom: 1px solid rebeccapurple;width:100%">
        <div style=" width: 60%; float: left; height: 100%;border-right:1px solid">
            <label style="font-size: 12px">*Juridisk navn </label>
            <div>
                <input style="background:none;border:none;font-size:12px;width:100%" type="text" value="">
            </div>
        </div>
        <div style="float: left;  height: 100%;width:40%;padding-left:10px;padding-bottom:10px;">
            <div>
                <label for="" style="font-size: 12px">*Juridisk adresse brukes til</label>
            </div>
            <span>
                <input type="checkbox" name="" id="" checked>
                <label style="font-size: 12px;">Alt</label>
            </span>
            <span>
                <input type="checkbox" name="" id="">
                <label style="font-size: 12px;">Reklamasjoner</label>
            </span>
            <span>
                <input type="checkbox" name="" id="">
                <label style="font-size: 12px;">Generell kommunikasjon</label>
            </span>
            <span>
                <input type="checkbox" name="" id="">
                <label style="font-size: 12px;">Produktforsendelser</label>
            </span>
            <span>
                <input type="checkbox" name="" id="">
                <label style="font-size: 12px;">Oppgjørsmelding</label>
            </span>
        </div>
    </div>
    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">


        <tr>
            <td>
                <label style="font-size: 12px">*Juridisk navn </label>
                <div>
                    <input style="background:none;border:none;font-size:12px;width:100%" type="text"
                        value="asd">
                </div>
            </td>
        </tr>

    </table>
    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">


        <tr>
            <td>
                <label style="font-size: 12px">*Postadresse (hvis ulik fra forretningsadresse)
                </label>
                <div>
                    <input style="background:none;border:none;font-size:12px;width:100%" type="text"
                        value="">
                </div>
            </td>
        </tr>

    </table>
    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">


        <tr>
            <td style="border-right: 1px solid;width:60%">
                <label style="font-size: 12px">Land</label>

                <input style="background:none;border:none;font-size:10px;" type="text" value="Norge">

            </td>
            <td>
                <label style="font-size: 12px">*Telefonnummer</label>

                <input style="background:none;border:none;font-size:10px;" type="text" value="">

            </td>
        </tr>


    </table>
    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">


        <tr>
            <td>
                <label style="font-size: 12px">*Kontaktperson (Fornavn/Etternavn)</label>

                <input style="background:none;border:none;font-size:10px;" type="checkbox" value="Kvinne">
                <label style="font-size: 12px">Kvinne</label>

                <input style="background:none;border:none;font-size:10px;" type="checkbox" value="Mann">
                <label style="font-size: 12px">Mann</label>


                <input style="background:none;border:none;font-size:12px;width:100%" type="text" value="">


            </td>
        </tr>


    </table>

    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">


        <tr>
            <td style="border-right: 1px solid;width:60%">
                <label style="font-size: 12px">*E-post</label>

                <input style="background:none;border:none;font-size:10px;" type="text" value="">

            </td>
            <td>
                <label style="font-size: 12px">Mobilnummer</label>

                <input style="background:none;border:none;font-size:10px;" type="text" value="">

            </td>
        </tr>


    </table>

    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">


        <tr>
            <td style="border-right: 1px solid;width:40%">
                <label style="font-size: 12px">*Utsalgsstedsnavn</label>

                <div class="">
                    <input style="background:none;border:none;font-size:10px;" type="text" value="">
                </div>

            </td>
            <td>
                <label style="font-size: 12px">*Utsalgsstedsadressen brukes til:</label>

                <input style="background:none;border:none;font-size:10px;" type="checkbox" value="Alt">
                <label style="font-size: 12px">Alt</label>

                <input style="background:none;border:none;font-size:10px;" type="checkbox" value="Reklamasjoner">
                <label style="font-size: 12px">Reklamasjoner</label>

                <input style="background:none;border:none;font-size:10px;" type="checkbox"
                    value="Generell kommunikasjon">
                <label style="font-size: 12px">Generell kommunikasjon</label>

                <input style="background:none;border:none;font-size:10px;" type="checkbox"
                    value="Produktforsendelser">
                <label style="font-size: 12px">Produktforsendelser</label>

                <input style="background:none;border:none;font-size:10px;" type="checkbox" value="Oppgjørsmelding">
                <label style="font-size: 12px">Oppgjørsmelding</label>

            </td>
        </tr>


    </table>

    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">


        <tr>
            <td>
                <label style="font-size: 12px">*Utsalgsstedets besøksadresse (hvis ulik adressene nevnt over)</label>
                <div>
                    <input style="background:none;border:none;font-size:12px;width:100%" type="text"
                        value="asd">
                </div>
            </td>
        </tr>

    </table>

    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">


        <tr>
            <td style="border-right: 1px solid;width:60%">
                <label style="font-size: 12px">Land</label>

                <input style="background:none;border:none;font-size:10px;" type="text" value="Norge">

            </td>
            <td>
                <label style="font-size: 12px">*Telefonnummer</label>

                <input style="background:none;border:none;font-size:10px;" type="text" value="">

            </td>
        </tr>


    </table>
    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">


        <tr>
            <td>
                <label style="font-size: 12px">*Kontaktperson (Fornavn/Etternavn)</label>

                <input style="background:none;border:none;font-size:10px;" type="checkbox" value="Kvinne">
                <label style="font-size: 12px">Kvinne</label>

                <input style="background:none;border:none;font-size:10px;" type="checkbox" value="Mann">
                <label style="font-size: 12px">Mann</label>


                <input style="background:none;border:none;font-size:12px;width:100%" type="text" value="">


            </td>
        </tr>


    </table>

    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">


        <tr>
            <td style="border-right: 1px solid;width:60%">
                <label style="font-size: 12px">*E-post</label>

                <input style="background:none;border:none;font-size:10px;" type="text" value="">

            </td>
            <td>
                <label style="font-size: 12px">Mobilnummer</label>

                <input style="background:none;border:none;font-size:10px;" type="text" value="">

            </td>
        </tr>


    </table>

    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">


        <tr>
            <td>
                <label style="font-size: 12px">Adresse for oppgjørsmelding (hvis ulik adressene nevnt over) </label>
                <div>
                    <input style="background:none;border:none;font-size:12px;width:100%" type="text"
                        value="">
                </div>
            </td>
        </tr>

    </table>

    <table style="width: 100%;background: blue;margin-top:15px;">
        <thead>
            <tr>
                <td style="color: white; font-weight: 600;">Selskapsinformasjon</td>
                <td style="color: white;">2</td>
            </tr>
        </thead>
    </table>
    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">
        <tr>
            <td>
                <label for="">
                    *Eierskap
                </label>
            </td>
            <td>
                <p style="margin: 0">

                    <input type="checkbox" name="" id="">
                    <label for="">Enkeltpersonforetak</label>
                </p>
                <p style="margin:0px">
                    <input type="checkbox" name="" id="">
                    <label for="">Annet (vennligst spesifiser)
                    </label>
                </p>
            </td>
            <td>
                <input type="checkbox" name="" id="" checked>
                <label for="">
                    Ansvarlig selskap
                </label>
            </td>
            <td>
                <input type="checkbox" name="" id="" checked>
                <label for="">
                    Aksjeselskap
                </label>
            </td>
            <td>
                <input type="checkbox" name="" id="" checked>
                <label for="">
                    Allmenn aksjeselskap
                </label>
            </td>

        </tr>
    </table>
    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">
        <tr>
            <td style="border-right: 1px solid;width:33%">
                <label for="">
                    (vennligst spesifiser)*
                </label>
                <p>
                    <input type="text" name="" id=""
                        style="background:none;border:none;font-size:12px;width:100%">
                </p>
            </td>
            <td style="border-right: 1px solid;width:33% ">
                <label for="">
                    *Nåværende eierskap fra og med dato
                </label>
                <p>
                    <input type="text" name="" id=""
                        style="background:none;border:none;font-size:12px;width:100%">
                </p>
            </td>
            <td style="width:33%">
                <label for="">
                    *Stiftelsesdato
                </label>
                <p>
                    <input type="text" name="" id=""
                        style="background:none;border:none;font-size:12px;width:100%">
                </p>
            </td>



        </tr>
    </table>
    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">
        <tr>
            <td style="border-right: 1px solid;width:33%">
                <label for="">
                    Butikknummer
                </label>
                <p style="margin: 0">
                    <input type="text" name="" id=""
                        style="background:none;border:none;font-size:12px;width:100%">
                </p>
            </td>
            <td style="border-right: 1px solid;width:33% ">
                <label for="">
                    *Er kortinnløsing nytt for deg?
                </label>
                <p style="margin: 0">
                    <input type="checkbox" name="" id="">
                    <label for="">Ja</label>
                    <input type="checkbox" name="" id="">
                    <label for="">Ja</label>
                </p>
            </td>
            <td style="width:33%">
                <label for="">
                    Hvis nei, hvem var din tidligere innløser?
                </label>
                <p style="margin: 0">
                    <input type="text" name="" id=""
                        style="background:none;border:none;font-size:12px;width:100%">
                </p>
            </td>



        </tr>
    </table>
    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">
        <tr>
            <td style="border-right: 1px solid;width:50%">
                <label for="">
                    *I hvilket land forekommer hoveddelen av virksomhetens inntekter fra?
                </label>
                <p style="margin: 0">
                    <input value="Norge" type="text" name="" id=""
                        style="background:none;border:none;font-size:12px;width:100%">
                </p>
            </td>
            <td style="border-right: 1px solid;width:25% ">
                <label for="">
                    *I hvilket land ble selskapet dannet
                </label>
                <p style="margin: 0">
                    <input value="Norge" type="text" name="" id=""
                        style="background:none;border:none;font-size:12px;width:100%">
                </p>
            </td>
            <td style="width:25%">
                <label for="">
                    Stating eid selskap
                </label>
                <p style="margin: 0">
                    <input type="checkbox" name="" id="">
                </p>
            </td>



        </tr>
    </table>
    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">
        <tr>
            <td style="width:100%">
                <label for="">
                    *Beskrivelse av virksomhet/bransje som du ønsker avtale for
                </label>
                <p style="margin: 0">
                    <input value="" type="text" name="" id=""
                        style="background:none;border:none;font-size:12px;width:100%">
                </p>
            </td>

        </tr>

    </table>
    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">
        <tr style="">
            <td style="width:100%;">
                <label for="">
                    Web-URL <span style="margin-left:5px">www.</span>
                </label>
                <p style="margin: 0">
                    <input value="" type="text" name="" id=""
                        style="background:none;border:none;font-size:12px;width:100%">
                </p>
            </td>

        </tr>

    </table>
    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">
        <tr style="border-top: 1px solid">
            <td style="border-right: 1px solid;width:33%">
                <label for="">
                    *Selskapets årlige omsetning
                </label>
                <p style="margin: 5px">
                    <input type="text" name="" id=""
                        style="background:none;border:none;font-size:12px;width:100%">
                </p>
            </td>
            <td style="border-right: 1px solid;width:33% ">
                <label for="">
                    *Total kredittkort-omsetning per år
                </label>
                <p style="margin: 5px">
                    <input type="text" name="" id=""
                        style="background:none;border:none;font-size:12px;width:100%">
                </p>
            </td>
            <td style="width:33%">
                <label for="">
                    *Gjennomsnittlig transaksjonsverdi
                </label>
                <p style="margin: 5px">
                    <input type="text" name="" id=""
                        style="background:none;border:none;font-size:12px;width:100%">
                </p>
            </td>
        </tr>

    </table>
    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">
        <tr style="border-top: 1px solid">
            <td style="border-right: 1px solid;width:33%">
                <label for="">
                    *Kortholder tilstede
                </label>
                <p style="margin: 5px">
                    <input type="text" name="" id=""
                        style="background:none;border:none;font-size:12px;width:80%">
                    <span>%</span>
                </p>
            </td>
            <td style="border-right: 1px solid;width:33% ">
                <label for="">
                    *Post-/Telefonordre
                </label>
                <p style="margin: 5px">
                    <input type="text" name="" id=""
                        style="background:none;border:none;font-size:12px;width:80%">
                    <span>%</span>
                </p>
            </td>
            <td style="width:33%">
                <label for="">
                    *Internet
                </label>
                <p style="margin: 5px">
                    <input type="text" name="" id=""
                        style="background:none;border:none;font-size:12px;width:80%">
                    <span>%</span>
                </p>
            </td>
        </tr>

    </table>

    <table style="width: 100%;background: blue;margin-top:10px">
        <thead>
            <tr>
                <td style="color: white; font-weight: 600;">Signaturberettiget</td>
                <td style="color: white;">3</td>
            </tr>
        </thead>
    </table>
    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">
        <tr>
            <td style="border-right: 1px solid;width:55%">
                <label for="">
                    *For-/etternavn
                    <input type="checkbox" name="" id="" style="margin-left: 5px"><label
                        style="margin-left: 5px">Kvinne</label>
                    <input type="checkbox" name="" id="" style="margin-left: 5px"><label
                        style="margin-left: 5px">Mann</label>
                </label>
                <p style="margin: 5px">
                    <input type="text" name="" id=""
                        style="background:none;border:none;font-size:12px;width:100%">
                </p>
            </td>
            <td style="border-right: 1px solid;width:15% ">
                <label for="">
                    *Fødselsdato
                </label>
                <p style="margin: 5px">
                    <input type="text" name="" id=""
                        style="background:none;border:none;font-size:12px;width:100%">

                </p>
            </td>
            <td style="width:15%;border-right:1px solid">
                <label for="">
                    *Andel
                </label>
                <p style="margin: 5px">
                    <input type="text" name="" id=""
                        style="background:none;border:none;font-size:12px;width:70%">
                    <span>%</span>
                </p>
            </td>
            <td style="width:15%">
                <label for="">
                    *Daglig leder
                </label>
                <p style="margin: 5px">
                    <input type="checkbox" name="" id="">
                    <label>Ja</label>
                    <input type="checkbox" name="" id="">
                    <label>Nei</label>
                </p>
            </td>
        </tr>

    </table>
    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">
        <tr>
            <td>
                <label for="">
                    *Privat adresse (inkl. postnr og sted)
                </label>
                <p style="margin: 5px">
                    <input type="text" name="" id=""
                        style="background:none;border:none;font-size:12px;width:100%">
                </p>
            </td>
        </tr>
    </table>
    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">
        <tr>
            <td style="border-right: 1px solid;border-right:1px solid;width:33%">
                <label for="">
                    *Land
                </label>
                {{-- <p style="margin: 5px"> --}}
                <input type="text" name="" id=""
                    style="background:none;border:none;font-size:12px;width:100%;width:33%">
                {{-- </p> --}}
            </td>
            <td style="border-right: 1px solid;border-right:1px solid">
                <label for="">
                    Telefonnummer
                </label>
                <input type="text" name="" id=""
                    style="background:none;border:none;font-size:12px;width:100%">
            </td>
            <td style="border-right: 1px solid; width:33%;">
                <label for="">
                    Mobilnummer
                </label>
                <input type="text" name="" id=""
                    style="background:none;border:none;font-size:12px;width:100%">
            </td>
        </tr>
    </table>
    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">
        <tr>
            <td>
                <label for="">
                    *E-post
                </label>
                <p style="margin: 5px">
                    <input type="text" name="" id=""
                        style="background:none;border:none;font-size:12px;width:100%">
                </p>
            </td>
        </tr>
    </table>
    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">
        <tr>
            <td style="border-right: 1px solid;border-right:1px solid;width:60%">
                <label for="">
                    *ID-nummer (pass, bankkort med ID eller førerkort)
                </label>
                {{-- <p style="margin: 5px"> --}}
                <input type="text" name="" id=""
                    style="background:none;border:none;font-size:12px;width:100%;width:33%">
                {{-- </p> --}}
            </td>
            <td style="border-right: 1px solid;border-right:1px solid;width:20%">
                <label for="">
                    Utstedelsesdato
                </label>
                <input type="text" name="" id=""
                    style="background:none;border:none;font-size:12px;width:100%">
            </td>
            <td style=" width:20%;">
                <label for="">
                    Utløpsdato
                </label>
                <input type="text" name="" id=""
                    style="background:none;border:none;font-size:12px;width:100%">
            </td>
        </tr>
    </table>
    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">
        <tr>
            <td>
                <label for="">
                    Nasjonalitet/Statsborgerskap (**obligatorisk kun for Signaturberettiget og Reelle rettighetshavere)
                </label>
                <p style="margin: 5px">
                    <input type="text" name="" id=""
                        style="background:none;border:none;font-size:12px;width:100%">
                </p>
            </td>
        </tr>
    </table>
    <table style="width: 100%;background: blue;margin-top:10px">
        <thead>
            <tr>
                <td style="color: white; font-weight: 600;">Finansiell informasjon</td>
                <td style="color: white;">4</td>
            </tr>
        </thead>
    </table>

    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">
        <tr>
            <td style="border-right: 1px solid;border-right:1px solid;width:60%">
                <label for="">
                    Bankens navn
                </label>
                {{-- <p style="margin: 5px"> --}}
                <input type="text" name="" id=""
                    style="background:none;border:none;font-size:12px;width:100%;width:33%">
                {{-- </p> --}}
            </td>
            <td style="border-right: 1px solid;border-right:1px solid;width:20%">
                <label for="">
                    *Bankkontoholders navn
                </label>
                <input type="text" name="" id=""
                    style="background:none;border:none;font-size:12px;width:100%">
            </td>
            <td style=" width:20%;">
                <label for="">
                    *Bankkontoholders navn
                </label>
                <input type="text" name="" id=""
                    style="background:none;border:none;font-size:12px;width:100%">
            </td>
        </tr>
    </table>
    <table style="width: 100%;background: blue;margin-top:10px">
        <thead>
            <tr>
                <td style="color: white; font-weight: 600;">Rapporteringssystem</td>
                <td style="color: white;">5</td>
            </tr>
        </thead>
    </table>

    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">
        <tr>
            <td style="border-right: 1px solid;border-right:1px solid;width:60%">
                <label for="">
                    Fullt navn på utvalgt registrert bruker av Rapporteringssystem service
                </label>
                {{-- <p style="margin: 5px"> --}}
                <div>
                    <input type="text" name="" id=""
                    style="background:none;border:none;font-size:12px;width:100%;width:33%">
                </div>
                {{-- </p> --}}
            </td>
            <td style="border-right: 1px solid;border-right:1px solid;width:20%">
                <label for="">
                    Foretrukket brukernavn (hvis noe)
                </label>
                <div>
                    <input type="text" name="" id=""
                    style="background:none;border:none;font-size:12px;width:100%">
                </div>
            </td>
            <td style=" width:20%;">
                <label for="">
                    E-postadresse og telefonnummer til registrert bruker
                </label>
                 <div>
                    <input type="text" name="" id=""
                    style="background:none;border:none;font-size:12px;width:100%">
                 </div>
            </td>
        </tr>
    </table>
    <table style="width: 100%;background: blue;margin-top:10px">
        <thead>
            <tr>
                <td style="color: white; font-weight: 600;width:94%">Signatur</td>
                <td style="color: white;width:6%">6</td>
            </tr>
        </thead>
    </table>

    <table style="width: 100%;background: #fff;border-top: 1px solid;border-bottom: 1px solid;">
        <tr>
            <td style="border-right: 1px solid;border-right:1px solid;width:50%">
                <label for="">
                    Signatur
                </label>
                {{-- <p style="margin: 5px"> --}}

                <img src="" alt="" height="50px">
                {{-- </p> --}}
            </td>
            <td style="border-right: 1px solid;border-right:1px solid;width:25%">
                <label for="">
                    Fullt navn og tittel (Blokkbokstaver)
                </label>
                <div>
                    <input type="text" name="" id="" value=""
                        style="background:none;border:none;font-size:12px;width:100%">
                </div>
            </td>
            <td style=" width:25%;">
                <label for="">
                    Dato (DD/MM/ÅÅÅÅ)
                </label>
                <div>
                    <input type="text" name="" id=""
                        style="background:none;border:none;font-size:12px;width:100%">
                </div>
            </td>
        </tr>
    </table>





</body>

</html>
