const JsonLdFetch = async (url, method = 'GET', data = null) => {
    const params = {
        method: method,
        headers: {
            'Accept': 'application/ld+json',
            'Content-type': 'application/json'
        }
    }
    if(data) params.body = JSON.stringify(data)
    let resp = await fetch(url);

    if(resp.status === 204) return null

    const responseData = await resp.json();
    if(resp.ok) {
        return responseData
    }else {
        throw responseData
    }
}
export default JsonLdFetch;