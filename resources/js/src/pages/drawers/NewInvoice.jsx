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
} from "antd";
import React from "react";
import { useEffect } from "react";
import { useNavigate } from "react-router";
import { useAddInvoiceMutation } from "../../services/invoiceApi";

const NewInvoice = ({ document_id, handleClick, showDrawer }) => {
  const formRef = React.createRef();
  const navigate = useNavigate();
  const [addInvoice, { data, isSuccess }] = useAddInvoiceMutation();
  const onFinish = async (value) => {
    let invoice = { ...value, document_id: document_id };
    await addInvoice(invoice);
  };
  useEffect(() => {
    if (isSuccess) {
      message.success(data.success);
      navigate("/dispatch");
    }
  }, data);
  return (
    <>
      <Drawer
        title="Add New Invoice"
        width={500}
        visible={showDrawer}
        onClose={handleClick}
      >
        <Form layout="vertical" ref={formRef} onFinish={onFinish}>
          <Form.Item name="document_id" hidden>
            <Input value={document_id} />
          </Form.Item>
          <Row gutter={16}>
            <Col span={24}>
              <Form.Item
                name="invoice_number"
                label="Invoice Number"
                rules={[{ required: true, message: "Please invoice number" }]}
              >
                <Input placeholder="Enter invoice number" />
              </Form.Item>
            </Col>
          </Row>
          <Row gutter={16}>
            <Col span={24}>
              <Form.Item
                name="attender_book_number"
                label="Attender Book Number"
              >
                <Input placeholder="Enter attender book number" />
              </Form.Item>
            </Col>
          </Row>
          <Row gutter={16}>
            <Col span={24}>
              <Form.Item
                name="subject"
                label="Subject"
                rules={[{ required: true, message: "Please enter subject" }]}
              >
                <Input placeholder="Please enter subject" />
              </Form.Item>
            </Col>
          </Row>
          <Row gutter={16}>
            <Col span={24}>
              <Form.Item
                name="receiver"
                label="Receiver"
                rules={[{ required: true, message: "Please enter receiver" }]}
              >
                <Input placeholder="Enter receiver" />
              </Form.Item>
            </Col>
          </Row>
          <Row gutter={16}>
            <Col span={24}>
              <Form.Item
                name="invoice_remarks"
                label="Remarks"
                rules={[{ required: true, message: "Enter remarks" }]}
              >
                <Input.TextArea rows={4} placeholder="Please enter remarks" />
              </Form.Item>
            </Col>
          </Row>
          <Row gutter={16}>
            <Col span={24}>
              <Space>
                <Button type="primary" htmlType="submit">
                  Submit
                </Button>
                <Button onClick={handleClick}>Cancel</Button>
              </Space>
            </Col>
          </Row>
        </Form>
      </Drawer>
    </>
  );
};

export default NewInvoice;
