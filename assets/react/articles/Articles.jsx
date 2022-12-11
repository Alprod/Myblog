import React from "react";
import {createRoot} from "react-dom/client";
import ShowArticles from "./components/Article";


const articles = document.getElementById('show-articles');
if(articles) {
    const root = createRoot(articles);
    const baseUrl = articles.dataset.url
    const img = articles.dataset.image
    console.log(baseUrl)
    root.render(<ShowArticles baseUrl={baseUrl} image={img} />)
}


