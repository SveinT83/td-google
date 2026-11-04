# ADR-0001: Fellesmoduler krever beslutning før endring

- Status: Akseptert
- Dato: 2026-11-04
- Modul: td-google
- Eierrepository: https://github.com/SveinT83/td-google
- RFC: [RFC-0001](../rfc/0001-rfc-adr-before-shared-changes.md)
- Beslutningstaker: Svein Tore, modulansvarlig
- Godkjenningskilde: uttrykkelig brukerbeslutning i arbeidsøkten 2026-11-04, gjengitt under Beslutning før implementering i RFC-0001.
- Erstatter / erstattet av: Ingen

## Beslutning og begrunnelse

Krev godkjent RFC og akseptert ADR før implementering i Core og alle andre fellesmoduler. Regelen følger kildeutgaven som AGENTS.md, portabel endringsregel og korte maler. Dokumentkravet gjelder før implementering, men innfører ingen generell ekstra manuell godkjenningsrunde. Et konkret oppdrag fra modulansvarlig kan allerede gi mandat til å skrive dokumentparet, registrere beslutningen og utføre endringen. KI kan ikke utvide mandatet eller påstå en menneskelig godkjenning som ikke finnes. Site kan endre kundens innhold, design og lokale funksjoner uten obligatorisk RFC/ADR så lenge endringen holder seg innenfor mandat, kontrakter og sikkerhetsgrenser.

## Konsekvenser

Kundeoppdagede fellesfeil blir analyser og forslag før de tas inn i eierrepositoryet. Små rettinger kan bruke korte dokumenter, men har samme beslutningsgrense. Modulkopier og vendor patches ikke direkte. Nye fellesmoduler arver kravet. Produksjonsmandat, backup, personvern og faktisk GitHub-tilgang gjelder uavhengig av dokumentstatus.

Denne dokumentasjonsendringen gis patchversjon, med manifest og kontroller oppdatert. Runtimekoden forblir uendret. Implementerings-/PR-status dokumenteres ved levering; Akseptert er beslutningsstatus og betyr ikke sammenslått eller publisert.
