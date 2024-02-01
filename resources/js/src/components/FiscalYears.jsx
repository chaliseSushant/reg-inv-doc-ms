import { Select } from "antd";
import React from "react";
import { useGetFiscalYearsQuery } from "../services/fiscalYearApi";

const FiscalYears = () => {
  const { data, isSuccess, isFetching } = useGetFiscalYearsQuery();
  return (
    <Select>
      {isSuccess &&
        data.map((item) => {
          return <Select.Option value={item.id}>{item.year}</Select.Option>;
        })}
    </Select>
  );
};

export default FiscalYears;
