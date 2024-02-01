import { ForwardFilled, PlusCircleOutlined, SendOutlined } from "@ant-design/icons";
import {
  Card,
  Col,
  Descriptions,
  Row,
  Skeleton,
  Space,
  Button,
  PageHeader,
} from "antd";
import React, { useState } from "react";
import { useParams } from "react-router";
import DocumentAssignees from "../components/DocumentAssignees";
import ViewRegistrationDocument from "../components/ViewRegistrationDocument";
import { useGetRegistrationDetailsQuery, useGetRegistrationDocumentQuery } from "../services/registrationApi";
import AddFile from "./drawers/AddFile";
import DocumentAssign from "./drawers/DocumentAssign";

const RegistrationDetails = () => {
  const { registration_id } = useParams();
  const { data: registrationData, isLoading } =
    useGetRegistrationDetailsQuery(registration_id);
  const [isVisible, setIsVisible] = useState(false);
  const [isVisibleAddFile, setIsVisibleAddFile] = useState(false);
  const showDrawer = () => {
    setIsVisible(true);
  };
  const showDrawerAddFile = () => {
    setIsVisibleAddFile(true);
  };
  const handleClick = () => {
    setIsVisible(!isVisible);
  };
  const handleClickAddFile = () => {
    setIsVisibleAddFile(!isVisibleAddFile);
  };
  if (isLoading) return <Skeleton active />;

  return (
    <>
      <Space direction="vertical">
        <PageHeader
          title="Registration Details"
          onBack={() => window.history.back()}
          extra={[
            <Button
              type="primary"
              onClick={handleClick}
              icon={<SendOutlined />}
            >
              Forward
            </Button>,
            <Button
            type="primary"
            onClick={handleClickAddFile}
            icon={<PlusCircleOutlined />}
          >
            Add File
          </Button>, 
          ]}
        />
        <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
          <Col span={16} className="gutter-row">
            <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
              <Col span={24}>
                <Descriptions title="Registration Details" bordered>
                  <Descriptions.Item label="Registration Number">
                    {registrationData.registration_number??"------------"}
                  </Descriptions.Item>
                  <Descriptions.Item label="Registration Date" span={2}>
                    {registrationData.registration_date??"------------"}
                  </Descriptions.Item>
                  <Descriptions.Item label="Letter Number" span={3}>
                    {registrationData.letter_number??"------------"}
                  </Descriptions.Item>
                  {registrationData.invoice_number && (
                    <Descriptions.Item label="Invoice Number">
                      {registrationData.invoice_number}
                    </Descriptions.Item>
                  )}
                  {registrationData.invoice_date && (
                    <Descriptions.Item label="Invoice Date" span={2}>
                      {registrationData.invoice_date}
                    </Descriptions.Item>
                  )}
                  <Descriptions.Item label="Subject" span={3}>
                    {registrationData.subject??"------------"}
                  </Descriptions.Item>

                  <Descriptions.Item label="Service">
                    {registrationData.service}
                  </Descriptions.Item>
                </Descriptions>
              </Col>
            </Row>
            <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
              <Col className="gutter-row" span={24}>
                <ViewRegistrationDocument registration_id = {registrationData.id}/>
              </Col>
            </Row>
          </Col>
          <Col span={8} className="gutter-row">
            <DocumentAssignees registration_id={registration_id} />
          </Col>
        </Row>
      </Space>
      
      <DocumentAssign
        showDrawer={isVisible}
        handleClick={handleClick}
        registration_id={registration_id}
      />
      <AddFile
        showDrawer={isVisibleAddFile}
        handleClick={handleClickAddFile}
        registration_id={registration_id}
      />

    </>
  );
};

export default RegistrationDetails;
