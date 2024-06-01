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


## ROTTA INDEX:
restituisce una collezione di dati.
Nel Controller dichiaro la funzione index() in cui, tramite una variabile, recupera l'elenco completo delle entità(=colonne) dal DB, mediante l'invocazione del metodo statico all() da parte della Classe (del Model), e mi restituirà sia la vista del file index.blade.php, collegato al file app.blade.php tramite lo @yield(), sia l'array associativo ottenuto tramite il metodo compact(), a cui assegno, come valore, la variabile dichiarata per la collection di dati.


## ROTTA SHOW:
restituisce le informazione di una specifica entità.
Sfrutta una rotta parametrica, ossia che necessita di un parametro, pertanto sarà un URL dinamico, così da restituire solo quella singola entità della tabella.
Nel Controller dichiaro la funzione show() a cui assegno un parametro che sarà associato all'istanza della classe (Model), facendomi ritornare alla vista del file show.blade.php, collegato al file app.blade.php tramite lo @yield(), sia l'array associativo ottenuto tramite il metodo compact(), a cui assegno, come valore, il parametro assegnato alla function.
Siccome farà riferimento ad una singola entità, nell'index.blade.php, al singolo elemento, creo un'ancora che mi porti alla vista show.blade.php:
href="{{route('rotta.show', ['parametro_rotta=>$elemento->proprietà'])}}" -> <a href="{{route('comic.show', $comic)}}"></a>


## ROTTA CREATE:
viene utilizzata per inserire nuovi record nella tabella attraverso la compilazione di un FORM, così da creare una nuova entità.
Viene creato il file create.blade.php (RESOURCES->VIEWS->CARTELLA_DELLE_VISTE).
Nel Controller dichiaro la funzione create() che mi rimanda al FORM nel file create.blade.php:
return view('nome_cartella.file') -> return view('comics.create')
Nel file WEB.php la sua posizione, in questo caso, DEVE essere necessariamente tra la Route comic.index & la Route comic.show, perchè il suo URL è simile all'url della rotta show.
(Laravel confronta le rotte in base alla richiesta del client e, se la rotta show precede la create, notando la somiglianza si ferma lì, restituendo errore)
Nel file header.blade.php ho inserito un bottone che rimanda al file create.blade.php contenente il FORM:

<form action="{{route('comic.store')}}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label text-white">Titolo</label>
        <input type="text" name="title" class="form-control" id="title" placeholder="Inserisci Titolo" value="{{old('title')}}">
    </div>

    //Altri label & input necessari
</form>

L'Attributo action conterrà l'url della ROTTA STORE, in quanto, quest'ultima, si occuperà di gestire i dati che il form invia, salvandoli.

La Direttiva @csrf (acronimo di Cross Site Request Forgery) è necessaria e fondamentale perchè funziona da meccanismo di sicurezza all'invio del form, qualora qualcuno voglia inviare dati obsoleti da altri applicativi.

Nell'Input associo il valore dell'attributo NAME (in questo caso name="title") all'attributo value, mediante l'helper 'old()' , per fare in modo che, qualora dovesse presentarsi un errore di compilazione, i campi correttamente compilati restino tali, mentre quelli errati perdano il dato inserito.
[questo grazie alla function store() della ROTTA STORE]
<input type="text" name="title" value="{{old('title')}}">

Dopo la validazione dei dati, da parte della function store() nel controller, snel file è necessario inserire un controllo, subito dopo il form, che salva in sessione gli errori per poi stamparli in pagina.
N.B. Questi errori hanno la validità di una sola richiesta al server (Flashed into the session), pertanto se la pagina viene ricaricata, verranno persi.
SE CI SONO ERRORI SALVATI IN SESSIONE [any() ritorna TRUE||FALSE]
    ALLORA STAMPA GLI ERRORI [per stamparli è necessario un ciclo foreach, perchè all() restituisce un array associativo con tutti gli errori salvati in sessione]
@if ( $errors->any() )
<div class="alert alert-danger op-90">
    <ul>
        @foreach($errors->all() as $error)
        <li>
            {{ $error }}
        </li>
        @endforeach
    </ul>
</div>
@endif


## ROTTA STORE:
viene utilizzata per gestire i dati all'invio del Form, della ROTTA CREATE.
A differenza delle rotte precedenti, la ROTTA STORE sfrutta il metodo statico POST, lo stesso metodo utilizzato nel FORM per l'invio dei dati.
Nel Controller dichiaro la funzione store() e gli passo come parametro l'istanza della classe Request (già importata di default nel controller), che contiene le differenti informazioni dei dati inseriti nel FORM.
    public function store(Request $request)
Nella funzione, grazie al parametro request, invoco il metodo validate() a cui passo un array associativo in cui la 'key' corrisponde all'entità della risorsa, mentre i 'valori' sono le regole di validazione (N.B. ogni singola regola è separata dal 'PIPE' -> | )
    $request->validate(['key'=>'required|url|nullable', //Altri valori])

Successivamente dichiaro una variabile ($form_data) che conterrà un array associativo con tutte le informazioni che arrivano dal form, tra cui anche il _token (utilizzato per verificare che l'utente autenticato sia la persona che effettivamente effettua le richieste all'applicazione. Poiché questo token è archiviato nella sessione dell'utente e cambia ogni volta che la sessione viene rigenerata), attraverso l'invocazione del metodo all() da parte dell'istanza $request.
Creo una nuova istanza grazie l'invocazione del metodo statico create(), da parte del Model, in cui passo come parametro la variabile che contiene l'array associativo, così da popolare la nuova istanza, con i dati arrivati dal form, ed eseguire il salvataggio degli stessi.
Infine ritorno alla ROTTA SHOW, per mostrare in dettaglio le caratteristiche della nuova entità ed eventualmente modificarli attraverso la ROTTA EDIT, eseguendo un redirect con il metodo to_route() a cui assegno 2 parametri: la ROTTA in cui voglio tornare e la nuova istanza.

Affinchè tutto funzioni e NON dia errore, è necessario che nel file Model 'Comic.php' (cartella APP->MODELS), venga definita la variabile $fillable, in modalità protetta, per l'assegnazione di massa, passandogli un array, al cui interno sono presenti tutte le proprietà restituite dell'array associativo della variabile $form_data.


## ROTTA EDIT:
viene utilizzata per modificare i record esistenti, attraverso la compilazione di un FORM, così da aggiornare l'entità.
Viene creato il file edit.blade.php (RESOURCES->VIEWS->CARTELLA_DELLE_VISTE).
Sfrutta una rotta parametrica, ossia che necessita di un parametro, pertanto è un URL dinamico, così da restituire un FORM precompilato di quella specifica entità.
Nel Controller dichiaro la funzione edit(), in cui passo come parametro l'istanza del Model (Comic in questo caso), così da rimandarmi al file edit.blade.php, con il FORM precompilato, con tutti i record di quell'entità:
return view('nome_cartella.file', compact('istanza')) -> return view('comics.edit', compact('comic'))
In WEB.php registro la ROTTA EDIT con l'URL '/url/{parametro}/edit'
Nel file show.blade.php & nel file index.blade.php ho aggiunto un link che mi rimanda al FORM precompilato, mediante l'assegnazione della rotta:
<a href="{{route('nome_rotta.edit', $parametro)}}"></a>

Nel file edit.blade.php viene creato un FORM:

<form action="{{route('comic.update', $comic)}}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="title" class="form-label text-white">Titolo</label>
        <input type="text" name="title" class="form-control" id="title" placeholder="Inserisci Titolo" value="{{old('title', $comic->title)}}">
    </div>

    //Altri label & input necessari
</form>

L'Attributo action conterrà l'url della ROTTA UPDATE, in quanto, quest'ultima, si occuperà di gestire i dati che il form invia, modificandoli e salvandoli.

La Direttiva @csrf (acronimo di Cross Site Request Forgery) è necessaria e fondamentale perchè funziona da meccanismo di sicurezza all'invio del form, qualora qualcuno voglia inviare dati obsoleti da altri applicativi.

La Direttiva @method('PUT') permette di indicare il tipo di metodo invocato dalla ROTTA UPDATE, quando risulta diverso da GET o POST, così da poter interpretare la chiamata alla Route.

Nell'Input associo sia il valore dell'attributo NAME (in questo caso name="title") all'attributo value, mediante l'helper 'old()' , per fare in modo che, qualora dovesse presentarsi un errore di compilazione, i campi correttamente compilati restino tali, mentre quelli errati perdano il dato inserito.
[questo grazie alla function store() della ROTTA STORE], sia l'elemento che invoca la proprietà:
<input type="text" name="title" value="{{old('title', $comic->title)}}">

N.B. nella <textarea> NON c'è l'attributo value, quindi il campo sarà inserito tra i suoi tag.


## ROTTA UPDATE:
viene utilizzata per gestire i dati all'invio del Form, della ROTTA EDIT.
Sfrutta una rotta parametrica, ossia che necessita di un parametro, pertanto è un URL dinamico, così da restituire nuovamente quella singola entità modificata tramite il FORM in edit.blade.php.
In Web.php registro la ROTTA invocando il metodo statico PUT/PATCH:
Route::put('/comics/{comic}', .... )

Nel Controller dichiaro la funzione update() e gli passo 2 parametrI:
1. l'istanza della classe Request (già importata di default nel controller), che contiene le differenti informazioni dei dati inseriti nel FORM.
2. L'istanza del Model (in questo caso Comic), che contiene tutti i record della singola entità evocata dalla ROTTA EDIT.
    public function store(Request $request, Comic $comic)
Nella funzione, grazie al parametro request, invoco il metodo validate() a cui passo un array associativo in cui la 'key' corrisponde all'entità della risorsa, mentre i 'valori' sono le regole di validazione (N.B. ogni singola regola è separata dal 'PIPE' -> | )
    $request->validate(['key'=>'required|url|nullable', //Altri valori])

Successivamente dichiaro una variabile ($form_data) che conterrà un array associativo con tutte le informazioni che arrivano dal form, tra cui anche il _token.
Tramite l'istanza del Model, invoco il metodo fill() che esegue un'assegnazione di massa, popolando l'entità già esistente con le nuove modifiche, sovrascrivendo i record.
Infine eseguo il salvataggio invocando il metodo save().

Eseguito il salvataggio, effettuo un redirect alla ROTTA SHOW, mediante il metodo to_route(), in cui passo come parametri sia il nome della rotta sia l'istanza.


## ROTTA DESTROY
viene utilizzata per eliminare un'entità dalla tabella.
Sfrutta una rotta parametrica, ossia che necessita di un parametro, pertanto è un URL dinamico, così da eliminare quella singola entità selezionata.
Nel Controller dichiaro la funzione destroy() a cui passo come parametro l'istanza del Model (Comic in questo caso), in cui verrà invocato il metrodo delete(), eseguendo infine un redirect alla ROTTA INDEX, mediante il metodo to_route() a cui passo solo il nome della rotta.
in Web.php la ROTTA invocando il metodo statico DELETE:
Route::delete('/comics/{comic}', .... )
In show.blade.php aggiungo un FORM che conterrà solo un BOTTONE per l'eliminazione dell'enetità:
<form action="{{route('comic.destroy', $comic)}}" method="POST">
    @csrf
    @method('DELETE')
    <button class="mt-4 btn btn-danger text-dark fw-bold">Delete Comic</button>
</form>

L'Attributo action conterrà sia l'url della ROTTA DESTROY sia il parametro dell'entità di riferimento, in quanto si occuperà dell'eliminazione dell'entità specifica.

La Direttiva @csrf (acronimo di Cross Site Request Forgery) è necessaria e fondamentale perchè funziona da meccanismo di sicurezza all'invio del form, qualora qualcuno voglia inviare dati obsoleti da altri applicativi.

La Direttiva @method('DELETE') permette di indicare il tipo di metodo invocato dalla ROTTA DESTROY, quando risulta diverso da GET o POST, così da poter interpretare la chiamata alla Route.



## BONUS
-- tramite javascript, quando l’utente clicca sul pulsante “delete”, chiedere conferma della cancellazione, prima di eliminare l’elemento.

DOPO 5 ORE TOTALI (SUDDIVISE IN 2 GIORNI), CON VARI TENTATIVI INUTILI, PRIVI DI SENSO, SENTIMENTI ED EMOZIONI, ED UN NERVOSO AD UN PASSO DALLA NEVROSI ISTERICA, HO TIRATO UN PROFONDO RESPIRO (ALTRETTANTO INUTILE) E, GRAZIE ALLA DOCUMENTAZIONE E A STACKOVERFLOW, HO CAPITO COME POTER SVOLGERE IL CONTROLLO, SENZA PERO' CAPIRE PERCHE' QEUSTO MALEDETTO CONTROLLO SUL BOTTONE NON FUNZIONI, NONOSTANTE FOSSE COLLEGATO ALL'EVENTLISTNER.

Al FORM della ROTTA DESTROY, nella pagina show.blade.php, ho assegnato l'attributo onsubmit="", a cui ho passato una funzione():

<form action="{{route('comic.destroy', $comic)}}" method="POST" onsubmit="return deleteFunction()">

Nello stesso file php, ho inserito il tag script per evocare la funzione dichiarata in onsubmit (DICHIARATA IN app.js NON VENIVA LETTA), in cui ho associato il metodo confirm() ad una variabile che ho poi controllato tramite l'if:
SE la variabile è diversa da TRUE, ALLORA ritorna FALSE.

<script>
    function deleteFunction() {

        const del = confirm("Sei sicuro?");

        if (!del) {
            return false;
        }
    }

    // function deleteFunction() {

    //     const del = confirm("Sei sicuro?");

    //     if (del !== true) {
    //         return false;
    //     }
    // }
</script>
NB. ONSUBMIT ritorna una funzione quando viene inviato un modulo.