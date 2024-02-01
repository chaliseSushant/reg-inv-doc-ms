import { configureStore, getDefaultMiddleware } from "@reduxjs/toolkit";
import { authApi } from "../services/authApi";
import { districtApi } from "../services/districtApi";
import { fiscalYearApi } from "../services/fiscalYearApi";
import { provinceApi } from "../services/provinceApi";
import { registrationApi } from "../services/registrationApi";
import { serviceApi } from "../services/serviceApi";
import { departmentApi } from "../services/departmentApi";
import { userApi } from "../services/userApi";
import { fileApi } from "../services/fileApi";
import { revisionApi } from "../services/revisionApi";
import { documentApi } from "../services/documentApi";
import { invoiceApi } from "../services/invoiceApi";
import { notificationApi } from "../services/notificationApi";

export default configureStore({
    reducer: {
        [provinceApi.reducerPath]: provinceApi.reducer,
        [districtApi.reducerPath]: districtApi.reducer,
        [authApi.reducerPath]: authApi.reducer,
        [fiscalYearApi.reducerPath]: fiscalYearApi.reducer,
        [registrationApi.reducerPath]: registrationApi.reducer,
        [serviceApi.reducerPath]: serviceApi.reducer,
        [departmentApi.reducerPath]: departmentApi.reducer,
        [userApi.reducerPath]: userApi.reducer,
        [fileApi.reducerPath]: fileApi.reducer,
        [revisionApi.reducerPath]: revisionApi.reducer,
        [documentApi.reducerPath]: documentApi.reducer,
        [invoiceApi.reducerPath]: invoiceApi.reducer,
        [notificationApi.reducerPath]: notificationApi.reducer,
    },
    middleware: (getDefaultMiddleware) =>
        getDefaultMiddleware().concat(
            provinceApi.middleware,
            districtApi.middleware,
            authApi.middleware,
            fiscalYearApi.middleware,
            registrationApi.middleware,
            serviceApi.middleware,
            departmentApi.middleware,
            revisionApi.middleware,
            userApi.middleware,
            fileApi.middleware,
            documentApi.middleware,
            invoiceApi.middleware,
            notificationApi.middleware
        ),
});
