import React from "react";
import ItemsCardLiElement from "./ItemsCardLiElement";

//React.memo me permet d'éviter de répéter le contenu plusieurs fois à chaque chargement de la page
const CardElement = ({article, baseUrl, image}) => {
    return <>
        <ul role="list" className="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 xl:gap-x-8">
            { article.map( a => <ItemsCardLiElement key={a.id}
                                                    item={a}
                                                    public={a.isPublic}
                                                    user={a.user.fullname}
                                                    baseUrl={baseUrl}
                                                    image={image} />) }
        </ul>
    </>
}

export default CardElement;