import React, {useEffect} from "react";
import usePaginatedFetch from "../../hooks/UsePaginatedFetch";
import CountElement from "../../hooks/CountElement";
import CardElement from "../../components/cardView/CardElement";
import SpinAnimate from "../../components/SpinAnimate";

const ShowArticles = ({baseUrl, image}) => {
    const {items: articles, load, loading, count, hasMore} = usePaginatedFetch('/app/article/all');
    useEffect(() => {
        load()
    }, [])
    return <>
        <h3 className="t4">Retrouver tout les articles</h3>
        <CountElement count={count} element={'article'}/>
        <CardElement article={articles} baseUrl={baseUrl} image={image} />

        { loading && <SpinAnimate /> }

        <nav className="bg-white dark:bg-slate-800 py-3 mt-3 flex items-center justify-between border-t border-gray-100"
             aria-label="Pagination">
            <div className="flex-1 flex justify-start">
                {hasMore && <button disabled={loading} className="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50" onClick={load}>Next</button>}
            </div>
        </nav>

    </>;
}

export default ShowArticles;