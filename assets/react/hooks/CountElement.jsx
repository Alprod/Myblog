import React from "react";
const CountElement = ({count, element}) => {
    return <h6 className="t6">A ce jour nous comptons {count} {element}{count > 1 ?'s':''}</h6>;
}
export default CountElement;