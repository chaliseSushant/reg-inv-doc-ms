import React from "react";
import { BrowserRouter as Router } from "react-router-dom";
import ReactDOM from "react-dom/client";
import App from "./App";
import "antd/dist/antd.css";

import store from "./app/store";
import { Provider } from "react-redux";

const root = ReactDOM.createRoot(document.getElementById("root"));
root.render(
    <Router>
        <Provider store={store}>
            <App />
        </Provider>
    </Router>
);
