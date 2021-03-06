<?php
require_once '../lib/View.php';
/**
 * Der Dispatcher ist dafür zuständig, alle Requests an den entsprechenden
 * Controller weiterzuleiten.
 *
 * Der Dispatcher schaut die URI des Requests an und leitet aufgrund davon die
 * Anfrage an die gewünschte Funktion im entsprechenden Controller weiter. Die
 * URI wird wie im folgenden Beispiel verarbeitet:
 *
 * /user/delete?id=7&foo=bar
 * | | └────┴─ GET Parameter stehen im Array $_GET zur Verfügung
 * | |
 * | └─ Der Wert nach dem zweiten Slash heisst so wie die Funktion, welche
 * | auf dem Contoller aufgeruft werden soll.
 * |
 * └─ Dem Wert nach dem ersten Slash wird noch "Controller" angehängt um
 * herauszufinden, wie der gewünschte Controller heisst.
 *
 * Sollte ein Teil in der URI nicht vorhanden sein, wird als Controllername
 * "DefaultController" bzw. "index" als Funktionsname verwendet.
 */
class Dispatcher {
	public static function dispatch() {
		// Die URI wird aus dem $_SERVER Array ausgelesen und in ihre
		// Einzelteile zerlegt.
		// /user/index/foo --> ['user', 'index', 'foo']
		$uri = $_SERVER ['REQUEST_URI'];
		$uri = strtok ( $uri, '?' ); // Erstes ? und alles danach abschneiden
		$uri = trim ( $uri, '/' ); // Alle / am anfang und am Ende der URI abschneiden
		$uriFragments = explode ( '/', $uri ); // In einzelteile zerlegen
		                                    
		// Den Namen des gewünschten Controllers ermitteln
		$controllerName = 'UserController';
		View::$activePage = 'UserController';
		if (! empty ( $uriFragments [0] )) {
			$controllerName = $uriFragments [0];
			$controllerName = ucfirst ( $controllerName ); // Erstes Zeichen grossschreiben
			View::$activePage = $controllerName;
			$controllerName .= 'Controller'; // "Controller" anhängen
		}
		
		// Den Namen der auszuführenden Methode ermitteln
		$method = 'index';
		if (! empty ( $uriFragments [1] )) {
			$method = $uriFragments [1];

		}
		//setzen, welche Seite genau ausgewählt ist.
		View::$activePage = View::$activePage . $method;
		
		// Den gewünschten Controller laden
		// Achtung! Hier stützt PHP ab, sollte der Controller nicht existieren
		require_once "../controller/$controllerName.php";
		
		// Eine neue Instanz des Controllers wird erstellt und die gewünschte
		// Methode darauf aufgerufen.
		$controller = new $controllerName ();

        if(! empty($uriFragments [2])){

            $controller->$method ($uriFragments[2]);
            }
        else{
		$controller->$method ();
	}}
}
