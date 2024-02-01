import React, { useState } from "react";
import {
  Drawer,
  Form,
  Select,
  Col,
  Row,
  Input,
  Space,
  Button,
  message,
  List,
} from "antd";
import { useEffect } from "react";
import { useGetRegistrationInvoiceQuery } from "../../services/documentApi";
import { useNavigate } from "react-router";

const ViewRegistrationInvoice = ({ showDrawer, handleClick, document_id }) => {
  const navigate = useNavigate();

  const { data, isError, isSuccess } =
    useGetRegistrationInvoiceQuery(document_id);
  isSuccess && console.log(data.registrations.length);
  let container = "";
  // useEffect(() => {
  //   if (isSuccess) {
  //     message.success(data.success);
  //     formRef.current.resetFields();
  //     handleClick();
  //   }
  // }, [data]);
  if (isSuccess) {
    if (data.registrations.length > 0) {
      container = (
        <>
          <Row gutter={16}>
            <Col span={24}>
              {data.registrations.map((registration) => {
                return (
                  <Button
                    type="primary"
                    onClick={() =>
                      navigate(`/registration_details/${registration.id}`)
                    }
                  >
                    View Registration
                  </Button>
                );
              })}
            </Col>
          </Row>
        </>
      );
    }
    else if (data.invoices.length > 0) {
      container = (
        <>
          <Row gutter={16}>
            <Col span={24}>
              <List itemLayout="horizontal"
              dataSource={data.invoices}
              renderItem={
                (item)=>(
                  <List.Item actions={[<Button type="primary" onClick={()=>navigate(`/invoice_details/${item.id}`)}>View Invoice</Button>]}>
                     <List.Item.Meta
                     title={item.receiver}
                     description={`${item.invoice_number} - ${item.invoice_datetime}`}
                     />   
                  </List.Item>
                )
              }
              >
              </List>
            </Col>
          </Row>
        </>
      );
    }
  }

  return (
    <>
      <Drawer
        title="Add New File"
        width={500}
        visible={showDrawer}
        onClose={handleClick}
      >
        {container}
      </Drawer>
    </>
  );
};

export default ViewRegistrationInvoice;
