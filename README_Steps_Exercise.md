1. Ho creato prima il DB su phpMyAdmin e successivamente, in VsCode, i files:
    Migration: php artisan make:migration create_nome_tabella_table (plurale, minuscolo)
    Seeder: php artisan make:seeder NomeSeeder
    Controller: php artisan make:controller NomeController
    Model: php artisan make:model NomeModel

2. Importo il Model sia nel Seeder sia nel Controller @use App\Models\NomeModel

3. Nella cartella VIEWS, presente nella cartella Resources, creo una cartella che conterrà le viste CRUD: index.blade.php; show.blade.php; create.blade.php; edit.blade.php

4. Nella Cartella CONFIG incollo il file 'comics.php' che al suo interno mi ritorna un array, necessario per popolare il DB.
Nel Seeder (cartella DATABASE->cartella SEEDERS) all'interno della function run(), creo una variabile che conterrà l'array recuperato con il metodo config() a cui è stato passato come parametro il file incollato nella cartella CONFIG:
$variabile = config('file_in_config') --> $comics = config('comics')
Ciclo l'array con un foreach e al suo interno creo una nuova istanza della classe Comic (del Model), recupero le proprietà e salvo con il metodo save().
foreach($array as $elemento) -> ($comics as $comic)
    $new_istanza = new Classe (); -> $new_comic = new Comic();
    $new_istanza->proprietà = $elemento['valore']; -> $new_comic->title = $comic['title'];
    //continuo con le altre proprietà
    $new_istanza->save(); -> $new_comic->save()

5. Nella Migration (cartella DATABASE->cartella MIGRATIONS) all'interno della function up() creo le colonne del DB, assegnando come primo parametro del metodo create, invocato dalla Classe Schema, il nome della tabella.
Al suo interno si invocano determinati metodi che corrisponderanno al tipo di colonne che vorranno costituire
$table->string('nome_colonna', valore); -> il valore, per il type string, deve essere compreso tra 1 e 255, quando non viene dichiarato di default viene applicato il massimo (255)

6. Nel file NomeController.php, nella cartella APP->HTTP->CONTROLLERS, dichiaro le diverse funzioni per le varie rotte che andrò a identificare nel file web.php, nella cartella ROUTES.
Per ogni rotta, oltre all'invocazione del metodo eseguito dall'Http(GET/POST), imposto due parametri: come primo l'URL a cui devo essere indirizzato; come secondo un array in cui sono prensenti il Controller::class, 'nome_metodo'.
Infine, tramite l'invocazione del metodo name(), gli assegno un nome:
Route::get('/url', [NomeController::class, 'nome_metodo'])->name('nome_rotta');

7. Definisco l'app.blade.php, nella cartella RESOURCES->VIEWS->LAYOUTS, come la struttura base HTML, in cui aggancerò gli altri file tramite il segnaposto @yield(), per il main, così da essere sostituito ogni volta che si viene indirizzati ad un URL differente (quindi quando cambia la rotta)

ROTTA INDEX:
restituisce una collezione di dati.
Nel Controller dichiaro la funzione index() che, tramite una variabile, recupera l'elenco completo delle entità(=colonne) dal DB, mediante l'invocazione del metodo statico all() da parte della Classe (del Model), e mi restituirà sia la vista del file index.blade.php, collegato al file app.blade.php tramite lo @yield(), sia l'array associativo ottenuto tramite il metodo compact(), a cui assegno, come valore, la variabile dichiarata per la collection di dati.

ROTTA SHOW:
restituisce le informazione di una determinata risorsa.
Sfrutta una rotta parametrica, ossia che necessita di un parametro, pertanto sarà un URL dinamico, così da poter restituire solo quella singola entità della tabella.
Nel Controller dichiaro la funzione show() a cui assegno un parametro che sarà associato all'istanza della classe (Model), facendomi ritornare alla vista del file show.blade.php, collegato al file app.blade.php tramite lo @yield(), sia l'array associativo ottenuto tramite il metodo compact(), a cui assegno, come valore, il parametro assegnato alla function.
Siccome farà riferimento ad una singola entità, nell'index.blade.php, al singolo elemento, creo un,ancora che mi porti alla vista show.blade.php:
href="{{route('rotta.show', ['parametro_rotta=>$elemento->proprietà'])}}" -> <a href="{{route('comic.show', $comic)}}"></a>


ROTTA CREATE:

