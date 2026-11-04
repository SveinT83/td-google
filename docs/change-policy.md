# Endringsregler for fellesmoduler

Denne regelen gjelder Core, Google, Commerce og alle nye fellesmoduler, enten arbeidet skjer i modulrepositoryet, hos Trønder Data eller i en kundes nettsideprosjekt. At kilden følger kunden gir ikke mandat til å endre den felles pakken direkte.

## Før implementering

1. Les vertens AGENTS.md, denne modulens AGENTS.md, endringsreglene og relevante eksisterende RFC-er og ADR-er.
2. Beskriv endringen i en RFC: feil/behov, omfang, alternativer, valgt forslag, berørte komponenter/nettsteder, kompatibilitet, testplan og tilbakevei. Også små feilrettinger trenger RFC og ADR, men dokumentene kan være korte.
3. Registrer beslutningen, begrunnelsen, konsekvensene og mandatets kilde i en tilknyttet ADR. Beslutningen tas av modulansvarlig eller utførende innenfor et uttrykkelig delegert endringsmandat. Først når RFC er Godkjent og ADR er Akseptert for det aktuelle omfanget, kan implementeringen begynne. En kundes feilrapport eller ønske er ikke i seg selv et mandat til å endre fellesmodulen.
4. Et konkret endringsoppdrag fra modulansvarlig kan allerede gi nødvendig mandat: KI skriver RFC og ADR først, registrerer beslutningen innenfor det mandatet og kan deretter implementere uten en ny godkjenningsrunde. Dokumentkravet oppretter ingen generell regel om manuell godkjenning av hver endring. KI skal aldri finne på en menneskelig godkjenning eller utvide eget mandat. Manglende mandat eller uavklart beslutning betyr at bare utredning og dokumentutkast kan fortsette.
5. Implementer i riktig kilderepository på en arbeidsgren. Knytt RFC og ADR til issue/PR. Generaliser uten kundeinnhold, oppdater versjon, manifest og relevante kontrakter/låsefiler, og verifiser berørte funksjoner før PR og utgivelse.

Kravet gjelder kode, komponenter, standardvisninger, CSS/JS, ruter, offentlige grensesnitt, avhengigheter, modulkonfigurasjon, nye moduler og endringer i modulens regler/dokumentasjon. Oppgradering til en annen modulutgave i et nettsted skal også beskrives med valgt versjon og kompatibilitetskontroll. Ingen automatisk oppgradering av andre kundesider.

Lesing, feilanalyse, tester uten produktendringer, feilrapportering og oppretting/oppdatering av RFC-/ADR-utkast er tillatt før beslutningen. Dette er forarbeidet til godkjenning, ikke tillatelse til å endre pakken. ADR-utkast skal ha Foreslått status; eksistensen av en fil er ikke en godkjenning.

## Dokumentplassering og sporbarhet

I modulens eierrepository brukes docs/rfc/NNNN-kort-navn.md og docs/adr/NNNN-kort-navn.md, med gjensidige lenker og dato. Gjenbruk en eksisterende godkjent RFC/ADR bare når den faktisk dekker endringen. Utvidet omfang krever oppdatert beslutning før implementering. Ikke omskriv historiske beslutninger som om de alltid gjaldt; en ny ADR kan erstatte en gammel.

I et kundeprosjekt er den installerte kildeutgaven låst. Legg lokale forslag i vertens docs/proposals/<modul>/rfc og docs/proposals/<modul>/adr, uten å endre modulmappe eller vendor. Når ansvarlig har overtatt og besluttet forslaget i eierrepositoryet, behold lenken dit. Mangler kunden tilgang, leveres et konkret forslag til ansvarlig; KI skal ikke utvide tilgang eller kontakte andre uten mandat. Kundens prosjekt kan bygges med den inkluderte, uendrede kildeutgaven uten tilgang til privat upstream.

Pakkeversjon og manifest oppdateres først som del av den besluttede endringen. Ikke forsegl en lokal kundepatch med nytt manifest for å skjule avvik, og ikke gjør endringen i vendor. Dokumentasjonen skal følge den distribuerte kildeutgaven, slik at også kundens KI kan lese reglene uten upstream-tilgang.

## Site har større frihet

Innenfor kundens oppdrag kan Site endre tekst, bilder, artikler, nye lokale sider/ruter, profil, layout, lokale komponenter og lokale funksjoner uten obligatorisk RFC/ADR, så lenge eksisterende modulkontrakter og sikkerhetsgrenser holdes. Bruk støttet konfigurasjon og dokumenterte utvidelsespunkter. En lokal visuell overstyring gjennom et dokumentert punkt er fortsatt en Site-endring.

Site-friheten omfatter ikke å patche/kopiere fellesmotoren for å omgå reglene, endre modulens grensesnitt eller bygge en skjult alternativ implementasjon av en fellesfunksjon. Generelle forbedringer som skal tilbake til fellesmodul følger RFC/ADR-løpet. Nye systemfunksjoner, innlogging, persondatalagring, betaling eller vesentlig endret dataflyt krever særskilt avklaring og relevant risiko-/arkitekturdokumentasjon også i Site. Eksisterende publiseringsmandat, backup, tester, personvern og URL-/SEO-krav gjelder fortsatt.

## Hva regelen håndhever

AGENTS.md instruerer KI og beskriver arbeidsflyten. Den er ingen teknisk tilgangssperre. Beskyttelse av fellesrepositoryer og rett til sammenslåing styres av faktiske GitHub-rettigheter og grenregler. Denne endringen oppretter eller utvider ingen tilganger.
