import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";
const baseUrl = process.env.MIX_REACT_APP_BASE_URL;

export const fiscalYearApi = createApi({
  reducerPath: "fiscalYearApi",
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
  tagTypes: ["FiscalYears"],
  endpoints: (builder) => ({
    getFiscalYears: builder.query({
      query: () => "/fiscal-years",
      providesTags: ["FiscalYears"],
    }),
  }),
});

export const { useGetFiscalYearsQuery } = fiscalYearApi;
