export const Get = (url) => fetch(url, { 
    method: 'GET',  
    headers: {  
        'Content-Type': 'application/json'
    } 
});

export const Post = (url, body) => fetch(url, { 
    method: 'POST', 
    body: JSON.stringify(body), 
    headers: {  
        'Content-Type': 'application/json'
    } 
});

export const FormDataFetch = (url, body) => fetch(url, { 
    method: 'POST', 
    body
});