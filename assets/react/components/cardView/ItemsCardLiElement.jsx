import React from 'react';
const dateFormat = {
    dateStyle: 'medium',
    timeStyle: 'short'
}

const ItemsCardLiElement = React.memo(({item, user, baseUrl, image}) => {
    let date = new Date(item.createdAt)
    const id = parseInt(item.id)
    return <>
        <li className="relative">
            <div className="group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-gray-500 overflow-hidden">
                <img src={ image } alt="" className="object-cover pointer-events-none group-hover:opacity-75" />
                <a type="button" href={baseUrl.replace('__id__', id)} className="absolute inset-0 focus:outline-none">
                    <span className="sr-only">View details for {item.title}</span>
                </a>
            </div>
            <h3 className="mt-3 text-gray-500 dark:text-gray-300">{item.title}</h3>
            <p className="block text-sm font-medium text-gray-500 dark:text-gray-100 pointer-events-none">Rédiger par { user }</p>
            <p className='block text-sm font-medium text-gray-500 dark:text-gray-100'>{date.toLocaleString(undefined, dateFormat)}</p>
        </li>
    </>
})
export default ItemsCardLiElement;