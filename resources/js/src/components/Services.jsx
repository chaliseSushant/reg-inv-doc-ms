import { Form, Select } from "antd";
import React from "react";
import { useGetServicesQuery } from "../services/serviceApi";

const Services = () => {
  const { data, isSuccess, isFetching } = useGetServicesQuery();
  return (
    <Form.Item name="service_id" label="Services">
      <Select name="service_id">
        {isSuccess &&
          data.map((item) => {
            return <Select.Option key={item.id} value={item.id}>{item.title}</Select.Option>;
          })}
      </Select>
    </Form.Item>
  );
};

export default Services;
