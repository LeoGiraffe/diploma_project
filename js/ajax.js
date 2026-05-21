async function ajax(url, data = {}, method = 'POST') {

    try {

        const options = {
            method,
            headers: {
                'Content-Type': 'application/json'
            }
        };

        if(method !== 'GET') {
            options.body = JSON.stringify(data);
        }

        const response = await fetch(url, options);

        return await response.json();

    } catch(error) {

        return {
            status: 'error',
            message: error.message
        };
    }
}