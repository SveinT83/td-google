# Arbeidsregler for td-google

## RFC og ADR før endringer

Les [endringsreglene](docs/change-policy.md) og relevante beslutninger før arbeid. Ingen implementering eller lokal patch av denne fellesmodulen før det konkrete omfanget har en godkjent RFC og en akseptert ADR innenfor dokumentert mandat. Et konkret oppdrag fra modulansvarlig kan gi dette mandatet; KI skriver dokumentparet før den utfører oppdraget, uten automatisk ny godkjenningsrunde. Uten mandat kan KI bare analysere og lage forslag. KI kan ikke utvide eget mandat eller finne på menneskelig godkjenning. Kravet gjelder også dokumentasjons-/regelendringer og små feilrettinger; forarbeid med RFC-/ADR-utkast er tillatt.

I kundens prosjekt: legg forslag i vertens docs/proposals/<modul>/rfc og docs/proposals/<modul>/adr. Ikke rediger den låste modulkopien eller vendor, og ikke omgå kravet ved å kopiere felleslogikk inn i Site. Maler finnes i docs/rfc/TEMPLATE.md og docs/adr/TEMPLATE.md i denne pakken. Site har større frihet innenfor kundens mandat og dokumenterte utvidelsespunkter; se endringsreglene for grensene.

- Endre kilden i https://github.com/SveinT83/td-google på arbeidsgren. Ikke rediger vendor eller en låst kundekopi.
- Bevar produksjonssperre, samtykkekrav, sanitiserte analysefelter, syntetiske tester og feiltolerant rapportlagring. Ingen live måling i Dev.
- Oppdater pakkeversjon og manifest kontrollert. Installer samme kildeutgave i verten, oppdater låsen og kjør integrasjonstester, JS-tester og frontendbygg.
- Ingen automatisk oppgradering av kundesider og ingen aktivering av Google eller nye tilganger som del av en modulutgivelse.
