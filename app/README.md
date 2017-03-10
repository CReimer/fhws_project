#I. Pflichtenheft

## 1. Zielbestimmung
* Eine Web Applikation zum Veröffentlichen und Teilen von Projekt-, Bachelor- und Masterarbeitsthemen (im Folgenden zusammenfassend als "Projekte" bezeichnet) an der Hochschule für angewandte Wissenschaften Würzburg-Schweinfurt erstellen.

### 1.1 Muss-Kriterien
* Einsehen von bereits abgeschlossenen und offenen Projekten
* Hochladen von neuen Projekten
* Bearbeiten von Projekten
* Auflisten aller Projekte
* Löschen von Projekten

### 1.2 Kann-Kriterien
* Login-Funktion
* Möglichkeiten zum Interagieren mit Projekten
* Kommentieren von Projekten
* Bewerten von Projekten
* Vormerken von Projekten (Merkliste)
* Such-Funktion
* Sortier-Funktion
* Unterstützung von Smartphones

### 1.3 Abgrenzungskriterien
* (keine)

## 2. Einsatz
### 2.1 Anwendungsbereiche
* Hochschule für angewandte Wissenschaften Würzburg-Schweinfurt

### 2.2 Zielgruppen
* Dozenten
* Studenten
* Besucher

### 2.3 Betriebsbedingungen
* (keine)

## 3. Umgebung
### 3.1 Software
**_Für das Front-End:_**
* HTML/CSS/JS
* Polymer 2.0

**_Für das Back-End:_**
* PHP
* MariaDB

**_Unterstützung:_**
* Google Chrome
* Mozilla Firefox
* Safari
* etc.

### 3.2 Hardware
* PC
* Tablet
* Smartphone

## 4 Funktionalität
### Studenten können:
* Projekt-, Bachelor- und Masterarbeitsthemen einsehen.
* neue Projekte selbst vorschlagen (mit/ohne zugehörigen Dozenten?).
* alte Projekte weiterführen (in Absprache mit dem jeweiligen Dozenten).
* Projekte bewerten, kommentieren, vormerken.
* Eigene Projekte bearbeiten und löschen.

### Dozenten können:
* Projekt-, Bachelor- und Masterarbeitsthemen einsehen.
* neue Projekte eintragen (mit/ohne zugehörige Studenten?).
* alte Projekte auf abgeschlossen oder offen setzen.
* Auf Kommentare antworten.
* Eigene Projekte bearbeiten und löschen.

### Besucher können:
* Projekt-, Bachelor- und Masterarbeitsthemen einsehen.

## 5 Daten
* (bisher unbekannt)

## 6 Leistungen
* Schneller Abruf dank Single-Page Application. Keine spezifischen zeitlichen Anforderungen.

## 7 Benutzeroberfläche
* Einfache Handhabung, wenige Funktionen

## 8 Qualitätsziele
Lediglich ein Prototyp, wichtig sind daher:
* Erweiterbarkeit
* Änderbarkeit
* Wartbarkeit

## 9 Ergänzungen
* (keine)

#II. Stichwörter

## PHP
PHP ist eine weit verbreitete Skriptsprache, deren Syntax sich an der von C und Perl anlehnt. Sie bietet die ideale Grundlage für eine webbasierte Anwendung und ist zusätzlich noch ideal für objektorientierte Programmierung geeignet.
PHP ist außerdem eine der wenigen Sprachen, die eine direkte Integration in den Apache Webserver bereitstellt und damit eine der effizientesten Programmiersprachen für Backendprogrammierung von Webanwendungen ist.
Die Entscheidung zu PHP entstand vorwiegend durch Vorerfahrung mit der Sprache. PHP ist eine ausgereifte und viele Male verbesserte Sprache, so dass für den Projektablauf keine größeren Probleme zu erwarten waren.

## PDO Extension
Um die Datenbank anzubinden ist die Wahl auf die PDO Extension gefallen. PDO ist eine von zwei erwähnenswerten Datenbank Extensions für PHP. Die zweite wäre MySQLi. PDO hat diverse Vorteile gegenüber MySQLi. PDO ist nicht fest von MySQL abhängig. Es gibt Unterstützung von diversen anderen Datebanksystemen, darunter PostgreSQL, Oracle DB oder MS SQL. Außerdem ist PDO nicht anfällig für SQL Injections. Dies wird erreicht, indem das volle SQL Statement nicht in PHP mit den PHP-internen Variablen angereichert wird. Variablen werden stattdessen an ein vorhandenes Statement gebunden. Dazu wird das komplette SQL Statement mit Platzhaltern versehen. An diese Platzhalter wird dann über die vom PDO Statement Objekt bereitgestellte bind() Funktion eine PHP Variable gebunden.

## Apache Webserver
Die Entscheidung zum Apache Webserver wurde ähnlich getroffen, wie die Entscheidung zu PHP. Apache bietet eine direkte Integration von PHP in den Apache Webserver und somit ist der Apache Webserver die erste Wahl für uns gewesen. Nginx oder Lighttpd haben zwar ebenfalls die Möglichkeit PHP Webanwendungen auszuführen, aber nicht mit einem vergleichbar geringen Konfigurationsaufwand. Welcher Webserver, das Backend beherbergt, ist für das Projekt aber eigentlich zweitrangig. Funktionsfähig wären alle drei genannten Server und die Integration in Apache ist nur sehr lose, so dass eine Konvertierung auf Nginx oder Lighttpd vergleichsweise wenig Aufwand darstellten würde. Ziel war es schnell an eine lauffähige Testumgebung zu kommen.

## Datenbank (MariaDB)
Auch im Bereich der Datenhaltung wurde ein eher konservativer Kurs gewählt. Statt einer modernen NoSQL Datenbank ist hier der Fokus auf einer ausgereiften SQL-basierten Datenbank geblieben, MariaDB. MariaDB ist als Nachfolger von MySQL entstanden. Nachdem Sun Microsystems von Oracle gekauft wurde. Gab es ein Zerwürfnis mit der Open Source Community und seitdem wird MariaDB erfolgreich von einer Open Source Community weiterentwickelt.
Relationale Datenbanken sind lange bewährt und sollten auch in einem möglichen Produktivbetrieb keine Probleme verursachen. 

## Slim Framework
Das Slim Framework ist ein Mikroframework und effizienten Implementierung von API Schnittstellen. An dem Slim App Objekt werden dann die unterschiedlichen API Routen angemeldet und von Slim entsprechend verwaltet und aufgerufen, sobald die entsprechende API von einem Client aufgerufen wird.
Ohne das Slim Framework müssten die Parameter, manuell ausgewertet werden, um die nötigen Routen für die REST API bereitzustellen.

## REST
REST steht für „Representational State Transfer“ und ist die Beschreibung zu einem bestimmten Programmierstil. REST ist eine Abstraktionsschicht für das WWW und stellt geeignete Best-Practices zur Verfügung. Kernkonzepte sind die Zustandslosigkeit und das CRUD Prinzip.
Zustandslosigkeit bedeutet, dass jede Anfrage an das Backend alle Informationen beinhalten muss, die für die Ausführung der Anfrage notwendig sind. Es kann nicht auf Informationen aus vorherigen Anfragen zurückgegriffen werden. Es wird also serverseitig keine Sessioninformation erfasst und gespeichert.

REST unterstützt in diesem Projekt eine saubere Trennung der drei Schichten (Datenhaltung, Logik, Darstellung). Jede Anfrage des Clients kann komplett unabhängig voneinander abgearbeitet werden.

## CRUD
CRUD ist ein Akronym für Create, Read, Update, Delete und bildet damit die grundlegenden Datenbankoperationen ab. Alle API-Befehle sollen über diese 4 Stadien dargestellt werden. In unserem Fall werden dazu die HTTP-Methoden GET, POST, PUT und DELETE eingesetzt. Übertragen auf SQL wären das die Befehle INSERT, SELECT, UPDATE und DELETE

## REST API
Die REST API in unserem Projekt besteht aus zwei großen Bereichen. Der Projects-Bereich und der Login-Bereich.
Beim Projects Bereich ist ein Teil mit ID und ohne ID zu unterscheiden. Es gibt die Möglichkeit Projekte über /projects abzurufen oder darüber ein neues Projekt anzulegen. Soll ein bestimmtes Projekt geladen werden muss diese an projects angehängt werden (/projects/:id). Darüber ist es möglich ein bestimmtes Projekt anzuzeigen oder ein Projekt zu löschen.
Der Loginbereich ist ebenfalls zweigeteilt. Der eigentliche Loginbereich und der Userbereich. Im eigentlichen Loginbereich findet die Kommunikation mit dem Loginserver der FHWS statt. Ein direkter Login über die FH-Server war leider nicht möglich, weil moderne Browser den Access-Control-Allow-Origin Header auswerten und unsere Testsysteme nicht auf den FH-Servern freigeschaltet sind. Wird das Loginhandling auf die Serverseite ausgelagert, unterliegt man mit PHP diesen Einschränkungen nicht.
Der Userbereich stellt sozusagen die Session wieder her. Da wir auf das CRUD-Prinzip setzen, haben wir nach jeder Anfrage keine Informationen, von wem diese Anfrage stammt. Ein spezieller Token auf Clientseite liefert die nötigen Informationen um das User-Objekt neuzuinitialisieren.

##Login
Am Server wird über das HTTP-Authentifizierungsverfahren durchgeführt. An den Server wird dazu der Request-Header "Authorization" gesendet. Dieser beinhaltet das Plaintext Wort "Basic" gefolgt von der Base64-codierten Verbindung aus Nutzername, einem Doppelpunkt und dem Passwort. Auf Serverseite werden diese Daten unverändert an die FH-Loginserver weitergeleitet. Von dort kommt im Response Header ein JSON Web Token, der an die Clientseite unverändert weitergeleitet wird.
Jede zukünftige Anfrage sendet im Request Header diesen Token mit, über den dann das User Objekt neu initialisiert werden kann. Die Neuinitialisierung wird wieder durch die FH Server ausgelöst, indem der Token verschickt wird und das User Objekt als Antwort zurück kommt.

## JSON Web Token
JSON Web Token ist ein offener, Industriestandard (RFC 7519), um die Kommunikation eines Nutzers vom Client zum Server auf sichere Weise zu repräsentieren. Ein JSON Web Token besteht üblicherweise aus drei Teilen, dem Header, der Payload und der Signatur. Diese drei Teile werden durch einen Punkt getrennt.

Der Header besteht aus zwei Teilen, dem Typ des des Token und die Bezeichnung des Algorithmus des Hashes. Der Typ ist im Fall von JSON Web Token ist dies immer „JWT“.

Der Payload enthält weitere Informationen über den Token. Darunter der Issuer, also der Ersteller, die Expiration Time, also die Zeit, nach der der Token ungültig wird. 

Die Signatur ist der eigentliche Teil, in dem die Authentifizierung stattfindet. Header und Payload werden beide Base64 kodiert und mit einem Punkt verbunden. Dies wird über HMACSHA512 signiert mit einem zusätzlichen geheimen Schlüssel. Diesen geheimen Schlüssel kennt nur der Server und dient als Sicherheit, dass der Token nicht manipuliert wurde.

## Polymer Library
Polymer ist eine JavaScript Library, die den kürzlich von W3C verabschiedeten Web Components Standard ausnutzt. Polymer ändert dabei den üblichen Programmierstil extrem. Unter Ausnutzung der Template Funktion in HTML5 können bestimmte Templates voll automatisiert an in JavaScript hinterlegte Objekte angepasst werden. Anstatt wie früher auf jede Änderung manuell mit DOM-Operationen zu reagieren und damit die Webansicht anzupassen, ändert Polymer diese automatisch.

Man kann damit beispielsweise ein HTML-DIV in ein Template schreiben, mit dem Typ 'dom-repeat'. Darin werden verschiedene Textbausteine als Variablen hinterlegt. Zusätzlich dazu wird ein JavaScript Array von Objekten mit diesem Template verlinkt. Jede Änderung in diesem verlinkten Array führt zur sofortigen Angleichung des DOMs an die neuen Gegebenheiten.

Diese Funktion nutzen wir in unserem Projekt in der Übersicht aller Projekte. Beim Start wird ein Array (projects) über die mit den von der REST API abgerufenen Daten gefüllt. Ändert man den Suchbegriff, werden neue Daten vom Backend abgerufen und in das gleiche Array überschrieben. Die Weboberfläche passt sich daran sofort an.

## Web Components
Web Components liefern erstmals ein einheitliches Konzept für Frontend-Entwicklung. Während man bisher auf eine Kombination aus jQuery und jQuery UI angewiesen war, können mit Web Components erstmals konfliktfrei externe Skripte eingebunden werden.
Web Components sind dadurch aber noch kein implementiertes Framework. Es ist eine Basis für ein Framework, dass viele neue Ideen ins Spiel bringt:
* HTML lässt sich durch beliebige Elemente erweitern.
* HTML Templates sind Vorlagen, die vom Browser vorgerendert werden, aber erst durch JavaScript an ihren vorgesehenen Platz kommen.
* Shadow DOM ist ein weiterer versteckter DOM. Die oben erwähnten Custom Elements haben eine Unterstruktur, die für den späteren Nutzer nicht relevant ist. Diese Struktur befindet sich in einem Shadow DOM und ist dadurch nur innerhalb des Elements sichtbar.

## Git und Github
Um den Code aller Projektteilnehmer ideal verwalten und überblicken zu können entschieden wir uns für dieses Projekt für das Versionsverwaltungssystem Git. Über den Online-Dienst Github konnte dann mithilfe der fachlichen Methoden der Softwaretechnik eine agile Entwicklung der Web Applikation gewährleistet werden. Aufgrund des kleinen Projektteams und der ausreichenden Möglichkeiten zum Issue Tracking und Projektmanagement auf Github verzichteten wir auf die Verwendung von Jira.

## JetBrains PHPStorm
Als Entwicklungsumgebung für das Backend und Teile des Frontends wurde die kostenpflichtige Software PHPStorm von JetBrains eingesetzt. Sie stellt eine auf PHP spezialisierte Version von IntelliJ IDEA dar und war daher die ideale Entwicklungsoberfläche für unser auf PHP bauendes Backend. Besonders hilfreich ist PHPStorm bei der Anbindung von Datenbanken in PHP-Webanwendungen.

#III. Aufbau des Backends

Wie bereits erwähnt arbeitet das Backend mit dem Slim Framework. Bei jeder Anfrage wird zunächst das Slim\App Objekt initialisiert. Dazu werden aus der routes.php alle vordefinierten Routen an der Slim\App angemeldet und zu gegebenem Zeitpunkt ausgeführt.

Die möglichen Routen werden von 7 weiteren Klassen verwaltet.

## class.Config

class.Config ist ein simpler Parser für eine JSON basierte Konfigurationsdatei. In dieser Konfigurationsdatei werden im Moment nur Datenbankinformationen erfasst, die Syntax könnte allerdings auch deutlich umfangreichere Daten erfassen.

Es ist für jedes Thema eine Obergruppe vorgesehen. Für die Datenbank wäre das „database“ und unterhalb dieser Obergruppe werden dann die Datenbankinformationen geregelt.
Besteht weiterer Bedarf an Konfigurationen könnte man für den entsprechenden Bereich eine neue Obergruppe definieren und darunter die notwendigen Parameter.

## class.Database
Als Datenbank-Backend wird PHP::PDO verwendet. Auch PDO muss initialisiert werden, und um dies nicht in den verschiedenen Funktionsklassen tun zu müssen gibt es hier eine spezielle Database Klasse zur weiteren Abstraktion der Datenbank. Die benötigen Informationen werden dabei mit Hilfe der class.Config bezogen. Spätere Funktionsklassen bekommen dann ein fertig initialisiertes PDO Objekt über die getPdo() Funktion.

## class.Login
Um den Login sauber durchführen zu können mussten wir ins Backend wechseln. Neben dem Access-Control-Allow-Origin Problem benötigen wir diese Vorgehensweise auch um gewisse Informationen über den Nutzer zu erfassen. So wird die K-Nummer, der Vor- und Nachname zusätzlich in unserer Datebank gespeichert. Dies dient dem Zweck, dass Vor- und Nachname auch anderen Nutzern angezeigt werden soll und wir diese Informationen nicht bei Bedarf von FH-Servern erfragen können.

## class.Projects
In dieser Klasse läuft das Meiste unseres Projektes ab. Sowohl Datenbankabfragen, als auch Änderungen an Datenbanken oder neue Elemente für die Datenbank wird hier geregelt.
* Soll ein neues Projekt angelegt werden wird dies von der `newProject()` Funktion übernommen.
* Änderungen werden von `patchProjectById()` durchgeführt.
* Das Löschen funktioniert über `delProjectById()`

(wobei wir uns dazu entschieden haben die Einträge nicht tatsächlich zu löschen, sondern in der Datenbank nur ein Flag zu setzen, das dem Status "gelöscht" entspricht. Tatsächliches Löschen hat in relationalen Datenbanken das Problem, dass andere Informationen von dem gerade zu löschenden Datensatz abhängen und damit schnell Datenleichen entstehen können.)

Der Zusammenhang zur REST API besteht wie folgt:
* `GET /projects` wird an `Projects::getProjects()` geleitet und gibt alle verfügbaren Projekte zurück.
* `GET /projects/7` wird an `Projects::getProjectById()` geleitet und gibt nur den Datensatz für das Projekt mit der ID 7 zurück.
* `POST /projects` wird an `Projects::newProject()` geleitet und erzeugt einen neuen Datensatz mit den mitgegebenen Informationen.
* `POST /projects/7` wird an `Projects::patchProjectById()` geleitet und editiert den Datensatz mit der ID 7, und schließlich
* `DEL /projects/7` wird von `Projects::delProjectById()` abgehandelt und markiert den Datensatz mit der ID 7 als gelöscht.

## class.User
Die Klasse User ist das Gegenstück zur Login Klasse. Ist ein Login erfolgreich, bekommen wir bei jeder neuen Anfrage des Clients einen Bearer Key zurück. Dieser kann von uns nicht geprüft werden, wenn man aber stattdessen eine Anfrage an den Login Server der FHWS stellt und ein sauberes User Objekt zurückbekommt ist der Nutzer sauber eingeloggt. Die Informationen des Loginservers können wir gleich auch verwenden um eine Verbindung zwischen der Clientsession und den Zusatzinformationen für einen User in unserer Datenbank herzustellen. Z.B. um zu prüfen ob der Nutzer berechtigt ist Änderungen durchzuführen kann über `User::areRightsElevated()` angefragt werden.

#IV. Aufbau der Datenbank
Die Datenbank besteht aus insgesamt 8 Tabellen: _projects_, _degreeProgram_, _status_, _types_, _users_ und die drei Verbindungstabellen _projects_degreeProgram_, _projects_type_ und _users_projects_ zum auflösen von m:n Beziehungen.

## projects
In der projects Tabelle werden die Projekte erfasst. Die meisten SQL Queries starten von dieser Tabelle aus. Gespeichert wird hier eine eindeutige ID des Projekts, der Name des Projekts, eine Beschreibung des Projekts, die K-Nummer des Supervisors, ein Primärschlüssel aus der Statustabelle, der Gelöscht Status und ein Erstellungsdatum.

## degreeProgram
Die degreeProgram Tabelle erfasst mögliche Studiengänge und definiert für die jeweiligen Studiengänge den Namen und einen Kurznamen

## status
In der status Tabelle werden mögliche Stadien der Projekte erfasst. Ist ein Projekt "offen", oder ist es bereits "abgeschlossen", oder ist es gerade "in Bearbeitung"

## types
Die types Tabelle erfasst um welche Art von Projekt es sich handelt bzw. für welche Art von Arbeit das Projekt geeignet ist. Unterschieden werden Masterarbeit, Bachelorarbeit und Projektarbeit.

## users
Die Usertabelle erfasst die verschiedenen User. Das ist einer der größten Schwachpunkte am Konzept, da hier unvermeidbare Redundanzen entstehen. Wir haben keinen dauerhaften Zugriff auf die Daten der FH und müssen uns daher die Informationen, die wir beim ersten Login eines Users erhalten zwischenlagern. Um diese Redundanz möglichst klein zu halten wird hier nur der Vor- und Nachname erfasst. Sollten irgendwann weitere Informationen nötig sein, müssen hier leider weitere Daten aus dem User Objekt des FH-Loginservers zwischengespeichert werden.

## projects_degreeProgram, projects_type, users_projects
Einige Tabellen sind nur als Verbindungstabellen vorgesehen. Das ist das übliche Vorgehen bei m:n Beziehungen in relationalen Datenbanken. In unserem Fall sind es 3 Verbindungstabellen, da es unser Wunsch war jedem Projekt mehr als ein Studiengang, mehr als ein Typ und mehr als einen Nutzer zuordnen zu können.

#V. Aufbau des Front-Ends
##Übersicht
Das Front-End setzt sich zusammen aus

- **HTML**
- **CSS**
- **JavaScript**

insbesondere unter Verwendung der Open Source JavaScript Library **Polymer**.

Ziel war es, eine Single Page Application zu schreiben welche zwar wenige Funktionen bedient, diese aber zuverlässig und anschaulich durchführt und präsentiert. Als Grundlage wurde dazu das Polymer Starter Kit v1.0 verwendet. Es dient als idealer Startpunkt für Apps mit einem Drawer-basierten Layout und bedient sich dem für Polymer typischen "PRPL Schemas":

- **Push** (critical resources for the initial route)
- **Render** (initial route)
- **Pre-cache** (components for remaining routes)
- **Lazy-load** (and progressively upgrade next routes on-demand)

Ein wichtiger Vorteil von Polymer den wir uns zu Nutzen gemacht haben war außerdem das Responsive Layout. Die Seite sollte soweit wie möglich unabhängig von Plattform, Bildschirmgröße etc. sein und z.B. auch auf kleineren Geräten einfach zu bedienen sein und ansprechend aussehen.

## index.html

Hier "beginnt" die App. Es werden ein paar wenige grundlegende CSS Elemente sowie Metadaten und optionale Angaben für mobile Betriebssysteme vordefiniert. Dient hauptsächlich zum Aufruf des `app-main` Elements.

## app-main.html

Hierbei handelt es sich um den Kern der Web-App. Alle Single Page Elemente sind hier untergebracht. Geregelt werden hier unter anderem:
* Das Routing mithilfe von `app-location` und `app-route`
* Das `app-drawer-layout` (Gemeint ist das gesamte Layout der Web App basierend auf Steuerung mithilfe der Sidebar)
* Das `app-drawer` Element (Beschreibt Inhalte und Funktion der Sidebar)
* Das `app-header-layout` (Der Header der Web Applikation, inklusive Login-Button)
* Das `iron-pages` Element (Listet alle Children von app-main, welche an die `page` Variable gebunden sind)
* Übergreifende CSS Elemente (z.B. Definition der Primary und Secondary Color für die gesamte App)
* Der modale Login-Dialog mithilfe von `paper-dialog`
* Der modale Delete-Dialog mithilfe von `paper-dialog`

###Zu app-location und app-route

Diese Polymer-Elemente definieren das Routing für die Single Page Application. Sie dienen als Grundgerüst und können beliebig weiter skaliert werden (z.B. Erweiterung um Kategorien beim Browsen). Dies war im Rahmen der Projektarbeit aber nicht nötig, weshalb wir uns auf eine simple Struktur beschränkt haben. Weitere Routing Elemente befinden sich in `app-detail` und `app-edit`.

###Login und Delete Dialog

Das Login Formular wird über einen modalen `paper-dialog` geregelt und ist jederzeit aufrufbar. Aufgrund der bisher ungelösten Probleme des `paper-dialog` Elements (siehe https://github.com/PolymerElements/paper-dialog/issues/79 ) haben wir den HTML-Teil des Delete Dialogs in `app-main` untergebracht.

##app-browse.html

Browse dient zum Durchsuchen aller Einträge und bietet eine Suchfunktion sowie Optionen zum Filtern der Treffer. Angezeigt werden Titel und sämtliche Details für das jeweilige Projekt in Containern. Der Button "Mehr Details" führt zu `app-detail` wo abhängig von der jeweiligen ID des Projektes weitere Informationen und Optionen zur Verfügung stehen.

Verwendete Polymer-Elemente:
* `iron-form` - Erweiterung der Standard `HTML <form>`
* `iron-ajax` - Dient dem Abruf aller vorhandenen Projekte ohne die Seite neu laden zu müssen

##app-detail.html

Hier erscheinen alle relevanten Informationen und eine ausführliche Beschreibung des Projektes. Außerdem kann der Eintrag bearbeitet oder gelöscht werden. Das Routing hat das Format `.../detail/:course_id`, wobei `course_id` die ID des Eintrags ist.

Verwendete Polymer-Elemente:
* `app-location`, `app-route` und `iron-ajax` für das Routing
* `iron-icons` - Icons von Google
* `paper-tooltip` - Text erscheint beim Hervorheben der Icons zum Bearbeiten und Löschen

##app-edit.html

`app-edit` dient zum Bearbeiten und Erstellen von neuen Einträgen. Verwendet werden größtenteils Standard HTML Elemente, da wir die von Polymer gestellten Elemente für Formular wie `paper-dropdown-menu` für umständlich und unausgereift hielten.

##app-my-item.html

`my-items` oder "Meine Projekte" dient als Übersicht über die eigens angelegten Projekt-/Bachelor- und Masterarbeiten. Hier werden nach erfolgreichem Login die eigenen Elemente aufgelistet. Außerdem können von hier aus neue Projekt-/Bachelor- und Masterarbeiten hinzugefügt werden.

##shared-styles.html

Shared-styles dient lediglich zum Auslagern von häufig wiederverwendeten CSS Elementen.

#VI. Anhang und benutzte Quellen

* Polymer Elemente - https://www.webcomponents.org/collection/Polymer/elements
* Polymer Starter Kit - https://github.com/PolymerElements/polymer-starter-kit
* Polymer Podcast "Polycast" - https://www.youtube.com/channel/UCnUYZLuoy1rq1aVMwx4aTzw
* HTML und CSS - https://www.w3schools.com/