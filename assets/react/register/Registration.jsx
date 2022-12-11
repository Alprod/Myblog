import React from "react";
import FormRegister from "../components/form/FormRegister";
import {createRoot} from "react-dom/client";

const container = document.getElementById('registration');
if(container) {
    const root = createRoot(container);
    root.render(<FormRegister />);
}

