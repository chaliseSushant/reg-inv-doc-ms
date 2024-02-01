import { Form, Layout, Input, Button, Checkbox, Row, Col } from "antd";
import React from "react";
import { useLoginMutation } from "../../services/authApi";

function Login({ setToken }) {
    const [login] = useLoginMutation();

    const onFinish = async (user) => {
        const response = await login(user);
        response.data.token && setToken(response.data.token);
    };
    return (
        <>
            <Row style={{ padding: "200px 0  0 400px" }}>
                <Col span={12}>
                    <Form
                        name="login_form"
                        labelCol={{ span: 8 }}
                        wrapperCol={{ span: 16 }}
                        initialValues={{ remember: true }}
                        autoComplete="off"
                        onFinish={onFinish}
                    >
                        <Form.Item
                            label="Email"
                            name="email"
                            rules={[
                                {
                                    required: true,
                                    message: "Please input your email!",
                                },
                            ]}
                        >
                            <Input />
                        </Form.Item>

                        <Form.Item
                            label="Password"
                            name="password"
                            rules={[
                                {
                                    required: true,
                                    message: "Please input your password!",
                                },
                            ]}
                        >
                            <Input.Password />
                        </Form.Item>

                        <Form.Item
                            name="remember"
                            valuePropName="checked"
                            wrapperCol={{
                                offset: 8,
                                span: 16,
                            }}
                        >
                            <Checkbox>Remember me</Checkbox>
                        </Form.Item>

                        <Form.Item
                            wrapperCol={{
                                offset: 8,
                                span: 16,
                            }}
                        >
                            <Button type="primary" htmlType="submit">
                                Submit
                            </Button>
                        </Form.Item>
                    </Form>
                </Col>
            </Row>
        </>
    );
}

export default Login;
