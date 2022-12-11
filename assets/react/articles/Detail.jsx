import React from "react";
import {createRoot} from "react-dom/client";
const ViewElement = ({urlDetail}) => {
    return <>
        <h1>Detaile</h1>
    </>
}
const detail = document.getElementById('detail-article')
if(detail) {
    const root = createRoot(detail)
    root.render(<ViewElement/>)
}