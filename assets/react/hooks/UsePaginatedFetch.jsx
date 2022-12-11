import React, {useCallback, useState} from "react";
import JsonLdFetch from "./JsonLdFetch";
const usePaginatedFetch = ( url ) => {
    //Loading met un etat d'atttente à mes articles
    const [loading, setLoading] = useState(false);
    //items seront mes articles
    const [items, setItems] = useState([]);
    const [count, setCount] = useState(0);
    const [next, setNext] = useState(null);
    //Une fonction de consomation de mon API
    const load = useCallback(async () => {
        //en attente d'une reponse
        setLoading(true)
        const response = await JsonLdFetch(  next || url)
        try {
            setItems((items) => [...items,...response['hydra:member']])
            setCount(response['hydra:totalItems'])
            if (response['hydra:view']) {

                if ( response['hydra:view']['hydra:next'] ) {
                    setNext(response['hydra:view']['hydra:next'])
                } else {
                    setNext(null)
                }
            }
        }catch (error) {
            console.error(error)
        }

        //reponse obtenu
        setLoading(false)

    }, [next, url]); //-> elle dependra de url
    return {
        items,
        load,
        loading,
        count,
        hasMore: next !== null,
    }
}
export default usePaginatedFetch;