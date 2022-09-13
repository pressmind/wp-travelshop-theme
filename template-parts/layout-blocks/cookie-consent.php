<?php
/**
 * consent.js is loaded in header.php to improve performance
 */
if (!TS_COOKIE_CONSENT) {
   return;
}
?>
<script>
    var cc = initCookieConsent();
    cc.run({
        autorun : true,
        delay : 0,
        current_lang : 'de',
        autoclear_cookies : true,
        cookie_expiration : 365,
        force_consent: false,
        hide_from_bots : true,
        gui_options : {
            consent_modal : {
                layout : 'cloud',
                position : 'bottom center',
                transition : 'slide'
            },
            settings_modal : {
                layout : 'box',
                transition : 'slide'
            }
        },
        onAccept: function(cookies){
            <?php if ( !empty(TS_GOOGLETAGMANAGER_UA_ID) ) { ?>
            if(cc.allowedCategory('analytics_cookies')){
                cc.loadScript('https://www.googletagmanager.com/gtag/js?id=UA-1234-1', function(){
                    window.dataLayer = window.dataLayer || [];
                    function gtag(){dataLayer.push(arguments);}
                    gtag('js', new Date());

                    gtag('config', 'UA-1234-1');
                });
            }
            <?php } ?>
        },
        <?php
        $cookie_consent_logo = '<img src="'. get_stylesheet_directory_uri() .'/assets/img/travelshop-logo.svg" height="24" width="142" class="d-inline-block align-middle" alt="'. get_bloginfo( 'name' ) .'">';
        ?>
        languages : {
            de : {
                consent_modal : {
                    title :  '<div class="pb-2"><?php echo $cookie_consent_logo; ?></div>Privatsphäre ist uns wichtig!',
                    description :  '<p>Wir verwenden Cookies, um Ihnen ein optimales Webseiten-Erlebnis zu bieten. Dazu zählen Cookies, die für den Betrieb der Seite und für die Steuerung unserer kommerziellen Unternehmensziele notwendig sind, sowie solche, die lediglich zu anonymen Statistikzwecken, für Komforteinstellungen oder zur Anzeige personalisierter Inhalte genutzt werden. Sie können selbst entscheiden, welche Kategorien Sie zulassen möchten. Bitte beachten Sie, dass auf Basis Ihrer Einstellungen womöglich nicht mehr alle Funktionalitäten der Seite zur Verfügung stehen. Weitere Informationen finden Sie in unseren <a href="<?php echo get_privacy_policy_url(); ?>" target="_blank" >Datenschutzhinweisen</a>.</p><p style="margin: 1rem 0 0 0"><a style="font-size: 0.75rem; opacity: .5" href="/impressum" target="_blank" >Impressum</a></p>',
                    primary_btn: {
                        text: 'Alle Cookies akzeptieren',
                        role: 'accept_all'				//'accept_selected' or 'accept_all'
                    },
                    secondary_btn: {
                        text : 'Individuelle Cookie-Einstellungen',
                        role : 'settings'				//'settings' or 'accept_necessary'
                    }
                },
                settings_modal : {
                    title : 'Individuelle Cookie-Einstellungen',
                    save_settings_btn : "Einstellungen übernehmen",
                    accept_all_btn : "Alle Cookies akzeptieren",
                    cookie_table_headers : [
                        {col1: "Name" },
                        {col2: "Anbieter" },
                        {col3: "Cookie Laufzeit" },
                        {col4: "Cookie Zweck" },
                        {col5: "Cookie Name" }
                    ],
                    blocks : [
                        {
                            title: '<?php echo $cookie_consent_logo; ?>',
                            description :  '<p>Wir verwenden Cookies, um Ihnen ein optimales Webseiten-Erlebnis zu bieten. Dazu zählen Cookies, die für den Betrieb der Seite und für die Steuerung unserer kommerziellen Unternehmensziele notwendig sind, sowie solche, die lediglich zu anonymen Statistikzwecken, für Komforteinstellungen oder zur Anzeige personalisierter Inhalte genutzt werden. Sie können selbst entscheiden, welche Kategorien Sie zulassen möchten. Bitte beachten Sie, dass auf Basis Ihrer Einstellungen womöglich nicht mehr alle Funktionalitäten der Seite zur Verfügung stehen. Weitere Informationen finden Sie in unseren <a href="<?php echo get_privacy_policy_url(); ?>" target="_blank" >Datenschutzhinweisen</a>.</p><p style="margin: 1rem 0 0 0"><a style="font-size: 0.75rem; opacity: .5" href="/impressum" target="_blank" >Impressum</a></p>',
                        },
                        {
                            title : "Notwendige Cookies",
                            description: 'Notwendige Cookies ermöglichen grundlegende Funktionen und sind für die einwandfreie Funktion der Website erforderlich',
                            toggle : {
                                value : 'necessary',
                                enabled : true,
                                readonly: true							//cookie categories with readonly=true are all treated as "necessary cookies"
                            }
                        },
                        <?php if ( !empty(TS_GOOGLETAGMANAGER_UA_ID) ) { ?>
                        {
                            title : "Statistiken",
                            description: 'Statistik-Cookies erfassen Informationen anonym. Diese Informationen helfen uns zu verstehen, wie unsere Besucher unsere Website nutzen.',
                            toggle : {
                                value : 'analytics_cookies',
                                enabled : false,
                                readonly: false
                            },
                            cookie_table: [
                                {
                                    col1: 'Google Tag Manager',
                                    col2: 'Google LLC',
                                    col3: '2 Jahre',
                                    col4: 'Google Tag ManagerDies ist ein Tag-Management-System zum Verwalten von JavaScript- und HTML-Tags, die für die Implementierung von Tracking- und Analysetools verwendet werden.<br><br>Verarbeitendes Unternehmen<br>Google Ireland LimitedGoogle Building Gordon House, 4 Barrow St, Dublin, D04 E5W5, Ireland<br><br>Datenverarbeitungszwecke<br>Diese Liste stellt die Zwecke der Datenerhebung und -verarbeitung dar. Eine Einwilligung gilt nur für die angegebenen Zwecke. Die gesammelten Daten können nicht für einen anderen als den unten aufgeführten Zweck verwendet oder gespeichert werden.<br>•Funktionalität<br><br>Genutzte Technologien<br>•Pixel<br><br>Erhobene Daten<br>Diese Liste enthält alle (persönlichen) Daten, die von oder durch die Nutzung dieses Dienstes gesammelt werden.•Aggregierte Daten zum Auslösen von Tags<br><br>Rechtsgrundlage<br>Im folgenden wird die erforderliche Rechtsgrundlage für die Verarbeitung von Daten genannt•Art. 6 Abs. 1 s. 1 lit. f DS-GVO<br><br>Ort der Verarbeitung<br>Vereinigte Staaten von Amerika<br><br>Aufbewahrungsdauer<br>Die Aufbewahrungsfrist ist die Zeitspanne, in der die gesammelten Daten für die Verarbeitung gespeichert werden. Die Daten müssen gelöscht werden, sobald sie für die angegebenen Verarbeitungszwecke nicht mehr benötigt werden.Die Daten werden nach 14 Tagen Abruf gelöscht.Datenempfänger•Alphabet Inc.•Google LLC•Google Ireland Limited<br><br>Datenschutzbeauftragter der verarbeitenden FirmaNachfolgend finden Sie die E-Mail-Adresse des Datenschutzbeauftragten des verarbeitenden Unternehmens.https://support.google.com/policies/contact/general_privacy_form<br><br>Weitergabe an Drittländer<br>Dieser Service kann die erfassten Daten an ein anderes Land weiterleiten. Bitte beachten Sie, dass dieser Service Daten außerhalb der Europäischen Union und des europäischen Wirtschaftsraums und in ein Land, welches kein angemessenes Datenschutzniveau bietet, übertragen kann. Falls die Daten in die USA übertragen werden, besteht das Risiko, dass Ihre Daten von US Behörden zu Kontroll- und Überwachungszwecken verarbeitet werden können, ohne dass Ihnen möglicherweise Rechtsbehelfsmöglichkeiten zustehen. Nachfolgend finden Sie eine Liste der Länder, in die die Daten übertragen werden. Dies kann für verschiedene Zwecke der Fall sein, z. B. zum Speichern oder Verarbeiten.<br><br>Weltweit<br>Klicken Sie hier, um die Datenschutzbestimmungen des Datenverarbeiters zu lesen https://policies.google.com/privacy?hl=enKlicken Sie hier, um auf allen Domains des verarbeitenden Unternehmens zu widerrufen https://safety.google/privacy/privacy-controls/Klicken Sie hier, um die Cookie-Richtlinie des Datenverarbeiters zu lesen https://www.google.com/intl/de/tagmanager/use-policy.html' ,
                                    col5: '_ga,_gat,_gid'
                                }
                            ]
                        }
                        <?php } ?>
                    ]
                }
            }
        }
    });
</script>