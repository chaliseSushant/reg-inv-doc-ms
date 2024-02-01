import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const baseUrl = process.env.MIX_REACT_APP_BASE_URL;


export const districtApi = createApi({
  reducerPath: "districtApi",
  baseQuery: fetchBaseQuery({ baseUrl,
    prepareHeaders: (headers) => {
      const token = sessionStorage.getItem("token")
      // If we have a token set in state, let's assume that we should be passing it.
      if (token) {
        headers.set("authorization", `Bearer ${token}`);
      }
      return headers;
    }, }),
  tagTypes:['Districts'],
  endpoints: (builder) => ({
    getDistricts: builder.query({
      query: (page=1) => `/districts?page=${page}`,
      providesTags:['Districts']
    }),
    addDistrict:builder.mutation({
      query:(district)=>({
        url:'/district/save',
        method:'POST', 
        body:district
      }),
      invalidatesTags:['Districts']
    }),
    updateDistrict:builder.mutation({
      query:(district)=>({
        url:'/district/update',
        method:'POST',
        body:district,
      }),
      invalidatesTags:['Districts']
    }),
    deleteDistrict:builder.mutation({
      query:(id)=>({
        url:`/district/delete/${id}`,
        method:'DELETE'
      }),
      invalidatesTags:['Districts']
    })
  }),
});

export const { useGetDistrictsQuery ,useAddDistrictMutation,useUpdateDistrictMutation,useDeleteDistrictMutation} = districtApi;
