import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const baseUrl = process.env.MIX_REACT_APP_BASE_URL;

export const provinceApi = createApi({
  reducerPath: "provinceApi",
  baseQuery: fetchBaseQuery({
    baseUrl,
    prepareHeaders: (headers) => {
      const token = sessionStorage.getItem("token");

      // If we have a token set in state, let's assume that we should be passing it.
      if (token) {
        headers.set("authorization", `Bearer ${token}`);
      }
      return headers;
    },
  }),
  tagTypes: ["Provinces"],
  endpoints: (builder) => ({
    getProvinces: builder.query({
      query: () => "/provinces",
      providesTags: ["Provinces"],
    }),
    addProvince: builder.mutation({
      query: (province) => ({
        url: "/province/save",
        method: "post",
        body: province,
      }),
      invalidatesTags: ["Provinces"],
    }),
    updateProvince: builder.mutation({
      query: (province) => ({
        url: "/province/update",
        method: "POST",
        body: province,
      }),
      invalidatesTags: ["Provinces"],
    }),
    deleteProvince: builder.mutation({
      query: (id) => ({
        url: `/province/delete/${id}`,
        method: "DELETE",
      }),
      invalidatesTags: ["Provinces"],
    }),
  }),
});

export const {
  useGetProvincesQuery,
  useAddProvinceMutation,
  useUpdateProvinceMutation,
  useDeleteProvinceMutation,
} = provinceApi;
