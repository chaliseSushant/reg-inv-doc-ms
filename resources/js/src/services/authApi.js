import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const baseUrl = "http://dcm/api";
const headers = {
  Accept: "application/json",
  "Content-Type": "application/json",
};

const createRequest = (url) => ({ url, headers });

export const authApi = createApi({
  reducerPath: "authApi",
  baseQuery: fetchBaseQuery({ baseUrl }),
  tagTypes:['User'],
  endpoints: (builder) => ({
    login: builder.mutation({
      query: (user) => ({
        url: '/login',
        headers,
        method: "post",
        body: user,
      }),
      invalidatesTags:['User']
    }),
  }),
});

export const { useLoginMutation } = authApi;
