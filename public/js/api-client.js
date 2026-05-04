/**
 * fechi fexi b native D

 */

const API_BASE_URL = '/api';

const ApiClient = {
    getToken() {
        return localStorage.getItem('donify_token');
    },

    setToken(token) {
        localStorage.setItem('donify_token', token);
    },

    removeToken() {
        localStorage.removeItem('donify_token');
    },

    getUser() {
        const user = localStorage.getItem('donify_user');
        return user ? JSON.parse(user) : null;
    },

    setUser(user) {
        localStorage.setItem('donify_user', JSON.stringify(user));
    },

    async request(endpoint, options = {}) {
        const url = `${API_BASE_URL}${endpoint}`;
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            ...options.headers,
        };

        if (headers['Content-Type'] === null) {
            delete headers['Content-Type'];
        }

        const token = this.getToken();
        if (token) {
            headers['Authorization'] = `Bearer ${token}`;
        }

        try {
            const response = await fetch(url, { ...options, headers });
            const data = await response.json();

            if (!response.ok) {
                if (response.status === 401) {
                    this.logout();
                }
                throw data;
            }

            return data;
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    },

    login(email, password) {
        return this.request('/auth/login', {
            method: 'POST',
            body: JSON.stringify({ email, password })
        }).then(data => {
            if (data.access_token) {
                this.setToken(data.access_token);
                this.setUser(data.user);
            }
            return data;
        });
    },

    register(userData) {
        const isFormData = userData instanceof FormData;
        return this.request('/auth/register', {
            method: 'POST',
            body: isFormData ? userData : JSON.stringify(userData),
            headers: isFormData ? { 'Content-Type': null } : {}
        });
    },



    registerOrganisation(fd) {
        return this.request('/organisations/register', {
            method: 'POST',
            body: fd,
            headers: { 'Content-Type': null }
        });
    },

    getFavourites() {
        return this.request('/favourites');
    },

    toggleFavourite(campaignId) {
        return this.request(`/campaigns/${campaignId}/favourite`, {
            method: 'POST'
        });
    },

    logout() {
        this.removeToken();
        localStorage.removeItem('donify_user');
        window.location.href = '/login';
    },

    isAuthenticated() {
        return !!this.getToken();
    },

    get(endpoint) {
        return this.request(endpoint, { method: 'GET' });
    },

    post(endpoint, data = {}) {
        const isFormData = data instanceof FormData;
        return this.request(endpoint, {
            method: 'POST',
            body: isFormData ? data : JSON.stringify(data),
            headers: isFormData ? { 'Content-Type': null } : {}
        });
    },

    put(endpoint, data = {}) {
        return this.request(endpoint, {
            method: 'PUT',
            body: JSON.stringify(data)
        });
    },

    delete(endpoint) {
        return this.request(endpoint, { method: 'DELETE' });
    }
};

window.ApiClient = ApiClient;
