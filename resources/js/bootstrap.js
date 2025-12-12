import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

// Import and initialize interceptors after axios is set
import "./axios-interceptor";
