
//| Manda un oggetto al DataBase specificando che ci deve fare
class DB {
    static get path() {
        //| Percorso del file PHP
        const url = new URL(window.location.origin);
        url.pathname = "/plain/db.php";
        return url;
    }

    static send(oper, data = []) {
        //| Invio
        const url = DB.path;
        const { searchParams: args } = url;
        url.pathname += `/${ encodeURI(oper) }`;
        args.set("data", JSON.stringify(data));
        
        //| Ricezione
        return fetch(url).then(async x => {
            const out = await x.text();
            try { return JSON.parse(out); }
            catch { throw new Error(`${ out } (status: ${ x.status })`); }
        });
    }
}

//| Definisce un getter sugli elementi HTML che permette di accedere all'oggetto fornito attraverso l'attributo "data-json"
HTMLElement.prototype.__defineGetter__("data", function() {
    return this.data_json ??= JSON.parse(this.getAttribute("data-json"));
});

//| Definisce una funzione per modificare un valore intermedio e restituirlo senza dover immagazzinarlo in una variabile; La funzione è definita in modo da non essere enumerabile , e quindi non venir selezionata a caso da altre funzioni
Object.defineProperty(Object.prototype, "but", {
    enumerable: false,
    value: function(f) {
        if (f instanceof Function)
        {
            const out = f(this);
            if (out instanceof Promise)
                return out.then(() => this);
        }
        return this;
    }
});