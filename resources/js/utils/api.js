class api {
    /**
     * Request top theater data.
     *
     * @returns {Promise<*>}
     */
    getTopTheaters = async (requestParams) => {
        console.log('in api');
        return await fetch('theaters/top?' + new URLSearchParams(requestParams), {
            method: "GET",
            headers: {
                "Content-type": "application/json",
                "Accept": "application/json"
            },
        }).then(response => response.json())
            .catch(error => error);
    }
}

export default new api();
