# RFC-0001: RFC og ADR før endringer i fellesmoduler

- Status: Godkjent
- Dato: 2026-11-04
- Modul: td-google
- Eierrepository: https://github.com/SveinT83/td-google
- Modulansvarlig / beslutningstaker: Svein Tore
- ADR: [ADR-0001](../adr/0001-rfc-adr-before-shared-changes.md)

## Problem og forslag

Kundens KI kan lese medfølgende modulkilde og oppdage feil eller ønsker som gjelder alle nettsteder. Vi trenger en lesbar beslutningsgrense før felleskode endres. Alle fellesmoduler skal derfor kreve en godkjent RFC og en akseptert ADR før implementering. Site får større frihet innenfor kundens mandat og eksisterende kontrakter.

## Omfang, alternativer og konsekvenser

Innfør AGENTS-henvisning, portabel endringsregel, korte RFC-/ADR-maler og denne beslutningen. Publiser som en dokumentasjonsutgave med patchversjon og oppdatert manifest; ta inkluderte Core-/Google-kopier og låsefil inn i starterens arbeidsgren. Ingen runtimefunksjon, nye avhengigheter eller GitHub-tilganger endres. Commerce forblir valgfri i eget repository.

Alternativet er fri direkte redigering av alle moduler, eller full RFC/ADR for alle kundens tekst-/designendringer. Første alternativ gir uoversiktlige fellesendringer; andre gir unødvendig administrasjon. Velg streng grense for fellesmoduler og avgrenset Site-frihet.

## Akseptanse og kontroll

- Regelen kan oppdages fra vertens AGENTS.md og modulens egen AGENTS.md, også i en distribuert kildekopi.
- KI kan analysere og skrive forslag, men ikke gi seg selv godkjenning eller patche en låst kundekopi.
- Dokumentmalene skiller forslag, beslutning og faktisk levering. Ett kort dokumentpar kan dekke en sammenhengende endring.
- Kilde-/manifest-/versjonskontroll og berørte integrasjonstester/bygg består. Runtimekoden skal være uendret.

Tilbakevei: tilbakefør dokumentasjonscommit og pakkeoppgradering samlet til forrige låste utgave. Ingen datamigrering.

## Beslutning før implementering

Godkjent av Svein Tore i denne arbeidsøkten 2026-11-04: Core skal ha KI-regler som krever RFC og ADR først ved feilrettinger, mangler eller endringsønsker; det samme gjelder andre fellesmoduler, mens Site kan være friere. Mandatet gjelder innføringen av denne arbeidsregelen, ikke forhåndsgodkjenning av fremtidige modulendringer. Dokumentparet opprettes før reglene og pakkemetadata endres.
