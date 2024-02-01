import {createApi,fetchBaseQuery} from '@reduxjs/toolkit/query/react';

const baseUrl = process.env.MIX_REACT_APP_BASE_URL;

export const serviceApi = createApi({
    reducerPath:'serviceApi',
    baseQuery:fetchBaseQuery({
        baseUrl,
        prepareHeaders:(headers)=>{
            const token = sessionStorage.getItem('token');
            if(token){
                headers.set('authorization',`Bearer ${token}`);
            }
            return headers;
        },
    }),
    tagTypes:["Services"],
    endpoints:(builder)=>({
        getServices:builder.query({
            query:()=>"/services",
            providesTags:["Services"]
        })
    })
});

export const {useGetServicesQuery} = serviceApi;