import { PlusOutlined } from "@ant-design/icons";
import { Button, Col, Popconfirm, Row, Skeleton, Space, Table } from "antd";
import React, { useState } from "react";
import {
  useDeleteDistrictMutation,
  useGetDistrictsQuery,
} from "../services/districtApi";
import NewDistrict from "./drawers/NewDistrict";

function Districts() {
  const [page,setPage] = useState(1);
  const [districtData, setDistrictData] = useState(null);
  const { data: districtList, isFetching } = useGetDistrictsQuery(page);
  console.log(districtList)
  const [deleteDistrict, { error }] = useDeleteDistrictMutation();
  const [isVisible, setIsVisible] = useState(false);
  const showDrawer = () => {
    setIsVisible(true);
  };
   
  const handleChange = (pagination,filters,sorter)=>
  {
      setPage(pagination);
  }
  const onEdit = (district) => {
    showDrawer();
    setDistrictData(district);
  };
  // close the drawer
  const handleClick = () => {
    setDistrictData(null);
    setIsVisible(!isVisible);
  };
  
  const confirm = (district) => {
    deleteDistrict(district.id);
  };
  const columns = [
    {
      title: "Name",
      dataIndex: "name",
      width: "30%",
    },
    {
      title: "Province",
      dataIndex: "province",
      sorter: true,
      width: "30%",
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
      render: (district) => (
        <Space>
          <Button type="primary" onClick={() => onEdit(district)}>
            Edit
          </Button>
          <Popconfirm
            title="Are you sure delete this record?"
            onConfirm={() => confirm(district)}
            okText="Yes"
            cancelText="No"
          >
            <Button type="danger">Delete</Button>
          </Popconfirm>
        </Space>
      ),
    },
  ];
  if(isFetching) return <Skeleton active/>
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
              Add New District
            </Button>
          </Col>
        </Row>
        <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
          <Col span={24} className="gutter-row">
            <Table
              columns={columns}
              pagination={{
                pageSize: 10,
                total: districtList.meta.total,
                onChange: handleChange,
                current:districtList.meta.current_page
              }}
              dataSource={!isFetching ? districtList.data : null}
            />
          </Col>
        </Row>
      </Space>
      <NewDistrict
        showDrawer={isVisible}
        handleClick={handleClick}
        districtData={districtData}
      />
    </>
  );
}

export default Districts;
