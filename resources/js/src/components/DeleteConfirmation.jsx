import { Popconfirm } from "antd";
import React from "react";

const DeleteConfirmation = ({ deleteProvince, children }) => {
  const confirm = () => {
    deleteProvince();
  };
  return (
    <Popconfirm
      title="Are you sure delete this task?"
      onConfirm={confirm}
      okText="Yes"
      cancelText="No"
    >
      {children}
    </Popconfirm>
  );
};

export default DeleteConfirmation;
