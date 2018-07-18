import axios from 'axios';

let server = "http://localhost:8000/api/weather"

export function getUserDashboard(userId) {
    console.log("getUserDashboard");
    return axios.get(`${server}/dashboard/user/${userId}`, { mode: 'CORS' })
        .then(resp => resp.data)
        .catch(error => error.response);
}

export function deleteCityFromDashboard(cityId) {
    console.log("deleteCityFromDashboard");
    return axios.delete(`${server}/dashboard/${cityId}`, { mode: 'CORS' })
        .then(resp => resp.data)
        .catch(error => error.response);
}

export function addCity(cityName, userId, userName) {
    console.log("addCity");
    let request = { cityName: cityName, userId: userId, userName: userName };
    return axios.post(`${server}/addCityCall`, JSON.stringify(request), { mode: 'CORS' })
        .then(resp => resp)
        .catch(error => alert(error.response.data.message));
}

export function getCityDetails(dashId) {
    console.log("getCityDetails");
    return axios.get(`${server}/details/${dashId}`, { mode: 'CORS' })
        .then(resp => resp.data)
        .catch(error => error.response);
}