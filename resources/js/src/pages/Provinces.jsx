import React, { useState, useEffect } from "react";
import { Row, Button, Col, Table, Space, Popconfirm } from "antd";
import { PlusOutlined } from "@ant-design/icons";
import NewProvince from "./drawers/NewProvince";
import {
  useDeleteProvinceMutation,
  useGetProvincesQuery,
} from "../services/provinceApi";

function Provinces() {
  const [isVisible, setIsVisible] = useState(false);
  const [provinceData, setProvinceData] = useState(null);
  const showDrawer = () => {
    setIsVisible(true);
  };
  const onEdit = (province) => {
    showDrawer();
    setProvinceData(province);
  };
  const { data: provinceList, isFetching } = useGetProvincesQuery();
  const [deleteProvince, { isLoading, error, isSuccess, isError }] =
    useDeleteProvinceMutation();

  // close the drawer
  const handleClick = () => {
    setProvinceData(null);
    setIsVisible(!isVisible);
  };
  const confirm = (province) => {
    deleteProvince(province.id);
  };

  const columns = [
    {
      title: "Name",
      dataIndex: "name",
      sorter: true,
      width: "40%",
    },
    {
      title: "Identifier",
      dataIndex: "identifier",
      width: "20%",
    },
    {
      title: "Action",
      dataIndex: "",
      key: "x",
      render: (province) => (
        <Space>
          <Button type="primary" onClick={() => onEdit(province)}>
            Edit
          </Button>
          <Popconfirm
            title="Are you sure delete this record?"
            onConfirm={() => confirm(province)}
            okText="Yes"
            cancelText="No"
          >
            <Button type="danger">Delete</Button>
          </Popconfirm>
        </Space>
      ),
    },
  ];
  return (
    <>
      <Space direction="vertical" size="middle" style={{ display: "flex" }}>
        <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
          <Col span={24} className="gutter-row">
            <Button
              type="primary"
              icon={<PlusOutlined />}
              onClick={handleClick}
            >
              Add New Province
            </Button>
          </Col>
        </Row>
        <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
          <Col span={24} className="gutter-row">
            <Table
              columns={columns}
              dataSource={!isFetching ? provinceList : null}
              pagination
            />
          </Col>
        </Row>
        <NewProvince
          showDrawer={isVisible}
          provinceData={provinceData}
          handleClick={handleClick}
        />
      </Space>
    </>
  );
}

export default Provinces;
