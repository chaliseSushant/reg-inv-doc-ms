import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const baseUrl = process.env.MIX_REACT_APP_BASE_URL;

export const departmentApi = createApi({
  reducerPath: "departmentApi",
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
  tagTypes: ["Departments"],
  endpoints: (builder) => ({
    getDepartmentList: builder.query({
      query: () => "/departments/list",
      providesTags: ["Departments"],
    }),
    getAllDepartment:builder.query({
        query:()=>"/departments",
        providesTags:["Departments"]
    }),
    addDepartment:builder.mutation({
      query:(department)=>({
        url:'/department/save',
        method:"POST",
        body:department
      }),
      invalidatesTags:["Departments"]
    }),
    updateDepartment:builder.mutation({
      query:(department)=>({
        url:"/department/update",
        method:"POST",
        body:department
      }),
      invalidatesTags:["Department"]
    }),
    deleteDepartment:builder.mutation({
      query:(department_id)=>({
        url:`/department/delete/${department_id}`,
        method:"DELETE"
      }),
      invalidatesTags:["Departments"]
    })
  }),
});

export const { useGetDepartmentListQuery,useGetAllDepartmentQuery,useAddDepartmentMutation,useUpdateDepartmentMutation,useDeleteDepartmentMutation } = departmentApi;
