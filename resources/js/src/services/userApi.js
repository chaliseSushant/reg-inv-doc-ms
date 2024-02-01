import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";
const baseUrl = process.env.MIX_REACT_APP_BASE_URL;

export const userApi = createApi({
  reducerPath: "userApi",
  baseQuery: fetchBaseQuery({
    baseUrl,
    prepareHeaders: (headers) => {
      const token = sessionStorage.getItem("token");
      if (token) {
        headers.set("authorization", `Bearer ${token}`);
      }
      return headers;
    },
  }),
  tagTypes: ["Users"],
  endpoints: (builder) => ({
    getUsers: builder.query({
      query: () => "/users",
      providesTags: ["Users"],
    }),
  }),
});

export const { useGetUsersQuery } = userApi;
